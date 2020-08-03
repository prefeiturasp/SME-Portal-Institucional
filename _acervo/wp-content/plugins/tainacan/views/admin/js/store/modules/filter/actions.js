import axios from '../../../axios';
import qs from 'qs';

// FILTERS --------------------------------------------------------
export const fetchFilters = ({ commit }, { collectionId, isRepositoryLevel, isContextEdit, includeDisabled, customFilters }) => {
    
    const source = axios.CancelToken.source();

    return new Object({ 
        request: new Promise((resolve, reject) => {
            
            let endpoint = '';
            if (!isRepositoryLevel) 
                endpoint = '/collection/' + collectionId + '/filters/';
            else
                endpoint = '/filters/';

            endpoint += '?nopaging=1';

            if (isContextEdit) {
                endpoint += '&context=edit';
            }

            if (includeDisabled){
                endpoint += '&include_disabled=' + includeDisabled;
            }

            if (customFilters != undefined && customFilters.length > 0) {
                let postin = { 'postin': customFilters };
                endpoint += '&' + qs.stringify(postin);
            }

            axios.tainacan.get(endpoint, { cancelToken: source.token })
                .then((res) => {
                    let filters= res.data;
                    commit('setFilters', filters);
                    resolve (filters);
                }) 
                .catch((error) => {
                    if (axios.isCancel(error)) {
                        console.log('Request canceled: ', error.message);
                    } else {
                        reject(error);
                    }
                });
        }),
        source: source
    });
};

export const sendFilter = ( { commit }, { collectionId, metadatumId, name, filterType, status, isRepositoryLevel, newIndex }) => {
    return new Promise(( resolve, reject ) => {
        let endpoint = '';
        if (!isRepositoryLevel) 
            endpoint = '/collection/' + collectionId + '/metadatum/' + metadatumId +'/filters/';
        else
            endpoint = '/filters/';

        axios.tainacan.post(endpoint + '?context=edit', {
            filter_type: filterType, 
            filter: {
                name: name,
                status: status
            },
            metadatum_id: metadatumId,
        })
            .then( res => {
                let filter = res.data;
                commit('setSingleFilter', { filter: filter , index: newIndex});
                resolve( filter );
            })
            .catch(error => {
                reject( error.response );
            });
    });
};

export const updateFilter = ( { commit }, { filterId, index, options }) => {

    if (options['metadatum'] != undefined && options['metadatum']['metadatum_id'] != undefined) {
        options['metadatum_id'] = options['metadatum']['metadatum_id'];
        delete options['metadatum'];
    }

    return new Promise(( resolve, reject ) => {
        let endpoint = '/filters/' + filterId;
        options['context'] = 'edit';

        axios.tainacan.put(endpoint, options)
            .then( res => {
                let filter = res.data;
                commit('setSingleFilter', { filter: filter, index: index });
                resolve( filter );
            })
            .catch(error => {
                console.log(error);
                reject({ error_message: error['response']['data'].error_message, errors: error['response']['data'].errors });
            });
    });
};

export const updateFilters = ( { commit }, filters) => {
    commit('setFilters', filters);
};

export const deleteFilter = ({ commit }, filterId ) => {
    let endpoint = '/filters/' + filterId;

    return new Promise((resolve, reject) => {
        axios.tainacan.delete(endpoint, { data:{ is_permanently: false }})
        .then( res => {
            commit('deleteFilter', res.data );
            resolve( res.data );
        }).catch((error) => {
            reject( error );
        });

    }); 
};

export const deleteTemporaryFilter = ({ commit }, index ) => {
    commit('deleteTemporaryFilter', index );
};

export const addTemporaryFilter = ({ commit }, filter ) => {
    commit('addTemporaryFilter', filter );
};

export const updateCollectionFiltersOrder = ({ commit }, { collectionId, filtersOrder }) => {
    return new Promise((resolve, reject) => {
        axios.tainacan.patch('/collections/' + collectionId + '/filters_order?context=edit', {
            filters_order: filtersOrder
        }).then( res => {
            commit('collection/setCollection', res.data, { root: true });
            commit('updateFiltersOrderFromCollection', res.data.filters_order);
            resolve( res.data );
        }).catch( error => { 
            reject( error.response );
        });

    });
};

export const fetchFilterTypes = ({ commit} ) => {
    return new Promise((resolve, reject) => {
        axios.tainacan.get('/filter-types')
        .then((res) => {
            let filterTypes = res.data;
            commit('setFilterTypes', filterTypes);
            resolve (filterTypes);
        })
        .catch((error) => {
            console.log(error);
            reject(error);
        });
    });
};

export const updateFilteTypes = ( { commit }, filterTypes) => {
    commit('setFilterTypes', filterTypes);
};

// REPOSITORY COLLECTION FILTERS - MULTIPLE COLLECTIONS ------------------------
export const fetchRepositoryCollectionFilters = ({ dispatch, commit } ) => {
    
    commit('clearRepositoryCollectionFilters');

    return new Promise((resolve, reject) => {

        dispatch('collection/fetchAllCollectionNames', { } ,{ root: true })
            .then((resp) => {
                resp.request
                    .then((res) => {
                        let collections = res;
                        if (collections != undefined && collections.length != undefined) {

                            let promises = [];

                            for (let collection of collections ) {
                                
                                let endpoint = '';
                                endpoint = '/collection/' + collection.id + '/filters/?nopaging=1&include_disabled=false';

                                promises.push(
                                    axios.tainacan.get(endpoint)
                                        .then((resp) => { return { filter: resp.data, collectionId: collection.id } }) 
                                        .catch((error) => {
                                            reject(error);
                                        })
                                );
                            }
                            axios.all(promises).then((results) => {
                                for (let resp of results) {
                                    let repositoryFilters = resp.filter.filter((filter) => { 
                                        return (filter.collection_id == 'default')
                                    });
                                    let collectionFilters = resp.filter.filter((filter) => {
                                        return (filter.collection_id != 'default')
                                    });
                                    commit('setRepositoryCollectionFilters', { collectionName: resp.collectionId, repositoryCollectionFilters: collectionFilters });
                                    commit('setRepositoryCollectionFilters', { collectionName: undefined, repositoryCollectionFilters: repositoryFilters });
                                }

                                resolve();
                            })  
                            .catch((error) => {
                                console.log(error);
                                reject(error);
                            })   
                        }
                    })
                    .catch(() => {
                        reject();
                    });

                    // Search Request Token for cancelling
                    resolve(resp.source);
            });
    });
};

// TAXONOMY FILTERS - MULTIPLE COLLECTIONS ------------------------
export const fetchTaxonomyFilters = ({ dispatch, commit }, taxonomyId ) => {
    
    commit('clearTaxonomyFilters');

    return new Promise((resolve, reject) => {
        dispatch('taxonomy/fetchTaxonomy', { taxonomyId: taxonomyId }, { root: true })
            .then((res) => {
                let taxonomy = res.taxonomy;
                if (taxonomy.collections_ids != undefined && taxonomy.collections_ids.length != undefined) {
                    
                    let amountOfCollectionsLoaded = 0;

                    for (let collectionId of taxonomy.collections_ids ) {
                
                        let endpoint = '';
                        endpoint = '/collection/' + collectionId + '/filters/?nopaging=1&include_disabled=false';

                        axios.tainacan.get(endpoint)
                            .then((resp) => {
                                let repositoryFilters = resp.data.filter((filter) => { 
                                    return (filter.collection_id == 'default') && filter.metadatum.metadata_type_object.options.taxonomy_id != taxonomyId
                                });
                                let collectionFilters = resp.data.filter((filter) => {
                                    return (filter.collection_id != 'default') && filter.metadatum.metadata_type_object.options.taxonomy_id != taxonomyId
                                });
                                commit('setTaxonomyFiltersForCollection', { collectionName: collectionId, taxonomyFilters: collectionFilters });
                                commit('setTaxonomyFiltersForCollection', { collectionName: undefined, taxonomyFilters: repositoryFilters });
                                amountOfCollectionsLoaded++;

                                if (amountOfCollectionsLoaded == taxonomy.collections_ids.length) {
                                    resolve();
                                }
                            }) 
                            .catch((error) => {
                                console.log(error);
                                reject(error);
                            });    
                    }
                }
            })
            .error(() => {
                reject();
            });
    });
};
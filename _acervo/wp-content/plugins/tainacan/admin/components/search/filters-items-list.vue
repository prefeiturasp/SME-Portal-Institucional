<template>
    <div class="extra-margin">
        <template v-if="taxonomyFilters != undefined">
            <div 
                    v-if="key == 'repository-filters'"
                    :key="index"
                    v-for="(taxonomyFilter, key, index) of taxonomyFilters">
                <div 
                        v-tooltip="{
                            delay: {
                                show: 500,
                                hide: 300,
                            },
                            content: $i18n.get('label_filters_from') + ' ' + taxonomyFiltersCollectionNames[key] + ': ',
                            autoHide: false,
                            classes: ['tooltip', isRepositoryLevel ? 'repository-tooltip' : ''],
                            placement: 'auto-start'
                        }" 
                        v-if="taxonomyFilter.length > 0 && taxonomyFiltersCollectionNames != undefined && taxonomyFiltersCollectionNames[key] != undefined"
                        class="collection-name">
                    {{ $i18n.get('label_filters_from') + " " + taxonomyFiltersCollectionNames[key] + ": " }}
                </div>
                <div    
                        v-if="taxonomyFilter.length > 0 && !(taxonomyFiltersCollectionNames != undefined && taxonomyFiltersCollectionNames[key] != undefined)"
                        class="collection-name">
                    <span 
                            style="width: 100%; height: 54px;"
                            class="icon has-text-centered loading-icon">
                        <div class="control has-icons-right is-loading is-clearfix" />
                    </span>
                </div>
                <tainacan-filter-item
                        v-show="!isMenuCompressed"        
                        :query="getQuery"
                        v-for="(filter, filterIndex) in taxonomyFilter"
                        :key="filterIndex"
                        :filter="filter"
                        :open="collapsed"
                        v-if="taxonomyFilter.length > 0"
                        :is-repository-level="key == 'repository-filters'"/>
                <!-- <p   
                        class="has-text-gray is-size-7"
                        v-if="taxonomyFilter.length <= 0">
                    {{ $i18n.get('info_there_is_no_filter') }}    
                </p> -->
                <hr v-if="taxonomyFilter.length > 0">
            </div>
            <div 
                    v-if="key != 'repository-filters'"
                    :key="index"
                    v-for="(taxonomyFilter, key, index) of taxonomyFilters">
                <div 
                        v-tooltip="{
                            delay: {
                                show: 500,
                                hide: 300,
                            },
                            content: $i18n.get('label_filters_from') + ' ' + taxonomyFiltersCollectionNames[key] + ': ',
                            autoHide: false,
                            classes: ['tooltip', isRepositoryLevel ? 'repository-tooltip' : ''],
                            placement: 'auto-start'
                        }" 
                        v-if="taxonomyFilter.length > 0 && taxonomyFiltersCollectionNames != undefined && taxonomyFiltersCollectionNames[key] != undefined"
                        class="collection-name">
                    {{ $i18n.get('label_filters_from') + " " + taxonomyFiltersCollectionNames[key] + ": " }}
                </div>
                <div    
                        v-if="taxonomyFilter.length > 0 && !(taxonomyFiltersCollectionNames != undefined && taxonomyFiltersCollectionNames[key] != undefined)"
                        class="collection-name">
                    <span 
                            style="width: 100%; height: 54px;"
                            class="icon has-text-centered loading-icon">
                        <div class="control has-icons-right is-loading is-clearfix" />
                    </span>
                </div>
                <tainacan-filter-item
                        v-show="!isMenuCompressed"        
                        :query="getQuery"
                        v-for="(filter, filterIndex) in taxonomyFilter"
                        :key="filterIndex"
                        :filter="filter"
                        :open="collapsed"
                        v-if="taxonomyFilter.length > 0"
                        :is-repository-level="key == 'repository-filters'"/>
                <!-- <p   
                        class="has-text-gray is-size-7"
                        v-if="taxonomyFilter.length <= 0">
                    {{ $i18n.get('info_there_is_no_filter') }}    
                </p> -->
                <hr v-if="taxonomyFilter.length > 0">
            </div>
        </template>
        <template v-else-if="isRepositoryLevel && taxonomyFilters == undefined">
            <collections-filter
                    :open="collapsed"
                    :query="getQuery"/>
            <div 
                    v-if="key == 'repository-filters'"
                    :key="index"
                    v-for="(repositoryCollectionFilter, key, index) of repositoryCollectionFilters">
                <div 
                        v-tooltip="{
                            delay: {
                                show: 500,
                                hide: 300,
                            },
                            content: $i18n.get('label_filters_from') + ' ' + repositoryCollectionNames[key] + ': ',
                            autoHide: false,
                            classes: ['tooltip', isRepositoryLevel ? 'repository-tooltip' : ''],
                            placement: 'auto-start'
                        }" 
                        v-if="repositoryCollectionFilter.length > 0 && repositoryCollectionNames != undefined && repositoryCollectionNames[key] != undefined"
                        class="collection-name">
                    {{ $i18n.get('label_filters_from') + " " + repositoryCollectionNames[key] + ": " }}
                </div>
                <div    
                        v-if="repositoryCollectionFilter.length > 0 && !(repositoryCollectionNames != undefined && repositoryCollectionNames[key] != undefined)"
                        class="collection-name">
                    <span 
                            style="width: 100%; height: 54px;"
                            class="icon has-text-centered loading-icon">
                        <div class="control has-icons-right is-loading is-clearfix" />
                    </span>
                </div>
                <tainacan-filter-item
                        v-show="!isMenuCompressed"        
                        :query="getQuery"
                        v-for="(filter, filterIndex) in repositoryCollectionFilter"
                        :key="filterIndex"
                        :filter="filter"
                        :open="collapsed"
                        v-if="repositoryCollectionFilter.length > 0"
                        :is-repository-level="key == 'repository-filters'"/>
                <!-- <p   
                        class="has-text-gray is-size-7"
                        v-if="taxonomyFilter.length <= 0">
                    {{ $i18n.get('info_there_is_no_filter') }}    
                </p> -->
                <hr v-if="repositoryCollectionFilters.length > 0">
            </div>
            <div 
                    v-if="key != 'repository-filters'"
                    :key="index"
                    v-for="(repositoryCollectionFilter, key, index) of repositoryCollectionFilters">
                <div 
                        v-tooltip="{
                            delay: {
                                show: 500,
                                hide: 300,
                            },
                            content: $i18n.get('label_filters_from') + ' ' + repositoryCollectionNames[key] + ': ',
                            autoHide: false,
                            classes: ['tooltip', isRepositoryLevel ? 'repository-tooltip' : ''],
                            placement: 'auto-start'
                        }" 
                        v-if="repositoryCollectionFilter.length > 0 && repositoryCollectionNames != undefined && repositoryCollectionNames[key] != undefined"
                        class="collection-name">
                    {{ $i18n.get('label_filters_from') + " " + repositoryCollectionNames[key] + ": " }}
                </div>
                <div    
                        v-if="repositoryCollectionFilter.length > 0 && !(repositoryCollectionNames != undefined && repositoryCollectionNames[key] != undefined)"
                        class="collection-name">
                    <span 
                            style="width: 100%; height: 54px;"
                            class="icon has-text-centered loading-icon">
                        <div class="control has-icons-right is-loading is-clearfix" />
                    </span>
                </div>
                <tainacan-filter-item
                        v-show="!isMenuCompressed"        
                        :query="getQuery"
                        v-for="(filter, filterIndex) in repositoryCollectionFilter"
                        :key="filterIndex"
                        :filter="filter"
                        :open="collapsed"
                        v-if="repositoryCollectionFilter.length > 0"
                        :is-repository-level="key == 'repository-filters'"/>
                <!-- <p   
                        class="has-text-gray is-size-7"
                        v-if="taxonomyFilter.length <= 0">
                    {{ $i18n.get('info_there_is_no_filter') }}    
                </p> -->
                <hr v-if="repositoryCollectionFilters.length > 0">
            </div>
        </template>
        <template v-else>
            <tainacan-filter-item
                    v-show="!isMenuCompressed"        
                    :query="getQuery"
                    v-for="(filter, index) in filters"
                    :key="index"
                    :filter="filter"
                    :open="collapsed"
                    :is-repository-level="isRepositoryLevel"/>
        </template>
    </div>
</template> 

<script>
    import { mapGetters, mapActions } from 'vuex';
    import CollectionsFilter from '../repository/collection-filter/collection-filter.vue';

    export default {
        data() {
            return {
                taxonomyFiltersCollectionNames: {},
                repositoryCollectionNames: {},
                collectionNameSearchCancel: undefined
            }
        },
        props: {
            filters: Array,
            collapsed: Boolean,
            isRepositoryLevel: Boolean,
            taxonomyFilters: Object,
            taxonomy: String,
            repositoryCollectionFilters: Object
        },
        watch: {
            taxonomyFilters() {
                if (this.taxonomyFilters != undefined) {
                    
                    this.$set(this.taxonomyFiltersCollectionNames, 'repository-filters', this.$i18n.get('repository'));
                                                    
                    // Cancels previous collection name Request
                    if (this.collectionNameSearchCancel != undefined)
                        this.collectionNameSearchCancel.cancel('Collection name search Canceled.');

                    this.fetchAllCollectionNames(Object.keys(this.taxonomyFilters))
                        .then((resp) => {
                            resp.request
                                .then((collections) => {
                                    for (let collection of collections)
                                        this.$set(this.taxonomyFiltersCollectionNames, '' + collection.id, collection.name);
                                });
                            // Search Request Token for cancelling
                            this.collectionNameSearchCancel = resp.source;     
                        });
                }
            },
            repositoryCollectionFilters() {
                if (this.repositoryCollectionFilters != undefined) {
                    
                    this.$set(this.repositoryCollectionNames, 'repository-filters', this.$i18n.get('repository'));
                    
                    // Cancels previous collection name Request
                    if (this.collectionNameSearchCancel != undefined)
                        this.collectionNameSearchCancel.cancel('Collection name search Canceled.');

                    this.fetchAllCollectionNames()
                        .then((resp) => {
                            resp.request
                                .then((collections) => {
                                    for (let collection of collections)
                                        this.$set(this.repositoryCollectionNames, '' + collection.id, collection.name);
                                });
                            // Search Request Token for cancelling
                            this.collectionNameSearchCancel = resp.source;
                        });
                }                
            }
        },
        methods: {
            ...mapGetters('search',[
                'getPostQuery'
            ]),
            ...mapActions('collection',[
                'fetchAllCollectionNames'
            ]),
        },
        computed: {
            getQuery() {
                return this.getPostQuery();
            },
            taxonomyId () {
                const taxonomyArray = this.taxonomy.split("_");
                return taxonomyArray[taxonomyArray.length - 1];
            }
        },
        components: {
            CollectionsFilter
        },
        beforeDestroy() {
            // Cancels previous collection name Request
            if (this.collectionNameSearchCancel != undefined)
                this.collectionNameSearchCancel.cancel('Collection name search Canceled.');
        }
    }
</script>

<style scoped>
    .extra-margin {
        margin-bottom: 40px;
    }
    .collection-name {
        color: #454647;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.875rem;
        margin-top: 1rem;
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
        width: 100%;
    }
    .is-loading:after {
        border: 2px solid white !important;
        border-top-color: #dbdbdb !important;
        border-right-color: #dbdbdb !important;
    }

</style>

<template>
    <div
            id="tainacan-subheader" 
            class="secondary-page">
           
        <div class="back-button is-hidden-mobile">
            <button     
                    @click="$router.go(-1)"
                    class="button is-turquoise4">
                <span class="icon">
                    <i class="tainacan-icon tainacan-icon-previous"/>
                </span>
            </button>
        </div>
        <div class="level">      
            <div class="level-left">
                <div class="back-button is-hidden-tablet level-item">
                    <button     
                            @click="$router.go(-1)"
                            class="button is-turquoise4">
                        <span class="icon">
                            <i class="tainacan-icon tainacan-icon-previous"/>
                        </span>
                    </button>
                </div>
                <div class="level-item">
                    <nav class="breadcrumbs">
                        <router-link 
                                tag="a" 
                                :to="$routerHelper.getCollectionsPath()">{{ $i18n.get('repository') }}</router-link>
                        &nbsp;>&nbsp; 
                        <router-link 
                                tag="a" 
                                :to="$routerHelper.getCollectionsPath()">{{ $i18n.get('collections') }}</router-link>
                        &nbsp;>&nbsp; 
                        <router-link 
                                tag="a" 
                                :to="{ path: collectionBreadCrumbItem.url, query: { fromBreadcrumb: true }}">{{ collectionBreadCrumbItem.name }}</router-link> 
                        <template v-for="(childBreadCrumbItem, index) of childrenBreadCrumbItems">
                            <span :key="index">&nbsp;>&nbsp;</span>
                            <router-link    
                                    :key="index"
                                    v-if="childBreadCrumbItem.path != ''"
                                    tag="a"
                                    :to="childBreadCrumbItem.path">{{ childBreadCrumbItem.label }}</router-link>
                            <span 
                                    :key="index"
                                    v-else>{{ childBreadCrumbItem.label }}</span>
                        </template>
                    </nav>
                </div>
            </div>
    
            <ul class="menu-list level-right">
                <li     
                        :class="activeRoute == 'ItemPage' || activeRoute == 'CollectionItemsPage' || activeRoute == 'ItemEditionForm' || activeRoute == 'ItemCreatePage' ? 'is-active':''" 
                        class="level-item"
                        v-tooltip="{
                            delay: {
                                show: 300,
                                hide: 100,
                            },
                            content: $i18n.get('items'),
                            autoHide: false,
                            placement: 'bottom-start',
                            classes: ['header-tooltips']
                        }">
                    <router-link 
                            tag="a" 
                            :to="{ path: collection && collection.id ? $routerHelper.getCollectionItemsPath(collection.id, '') : '' }" 
                            :aria-label="$i18n.get('label_collection_items')">               
                        <span class="icon">
                            <i class="tainacan-icon tainacan-icon-20px tainacan-icon-items"/>
                        </span>
                        <!-- <span class="menu-text">{{ $i18n.get('items') }}</span> -->
                    </router-link>
                </li>
                <li 
                        v-if="collection && collection.current_user_can_edit"
                        :class="activeRoute == 'CollectionEditionForm' ? 'is-active':''" 
                        class="level-item"
                        v-tooltip="{
                            delay: {
                                show: 300,
                                hide: 100,
                            },
                            content: $i18n.get('label_settings'),
                            autoHide: false,
                            placement: 'bottom-start',
                            classes: ['header-tooltips']
                        }">
                    <router-link
                            tag="a" 
                            :to="{ path: collection && collection.id ? $routerHelper.getCollectionEditPath(collection.id) : '' }" 
                            :aria-label="$i18n.get('label_settings')">
                        <span class="icon">
                            <i class="tainacan-icon tainacan-icon-20px tainacan-icon-settings"/>
                        </span>
                    
                    <!-- <span class="menu-text">{{ $i18n.get('label_settings') }}</span> -->
                    </router-link>
                </li>
                <li 
                        v-if="collection && collection.current_user_can_edit_metadata"
                        :class="activeRoute == 'MetadataList' ? 'is-active':''"
                        class="level-item"
                        v-tooltip="{
                            delay: {
                                show: 300,
                                hide: 100,
                            },
                            content: $i18n.getFrom('metadata', 'name'),
                            autoHide: false,
                            placement: 'bottom-start',
                            classes: ['header-tooltips']
                        }">
                    <router-link  
                            tag="a" 
                            :to="{ path: collection && collection.id ? $routerHelper.getCollectionMetadataPath(collection.id) : '' }"
                            :aria-label="$i18n.get('label_collection_metadata')">
                        <span class="icon">
                            <i class="tainacan-icon tainacan-icon-20px tainacan-icon-metadata"/>
                        </span>
                    <!-- <span class="menu-text">{{ $i18n.getFrom('metadata', 'name') }}</span> -->
                    </router-link>
                </li>
                <li 
                        v-if="collection && collection.current_user_can_edit_filters"
                        :class="activeRoute == 'FiltersList' ? 'is-active':''" 
                        class="level-item"
                        v-tooltip="{
                            delay: {
                                show: 300,
                                hide: 100,
                            },
                            content: $i18n.getFrom('filters', 'name'),
                            autoHide: false,
                            placement: 'bottom-start',
                            classes: ['header-tooltips']
                        }">
                    <router-link 
                            tag="a" 
                            :to="{ path: collection && collection.id ? $routerHelper.getCollectionFiltersPath(collection.id) : ''}" 
                            :aria-label="$i18n.get('label_collection_filters')">
                        <span class="icon">
                            <i class="tainacan-icon tainacan-icon-20px tainacan-icon-filters"/>
                        </span>
                    <!-- <span class="menu-text">{{ $i18n.getFrom('filters', 'name') }}</span> -->
                    </router-link>
                </li>
                <li 
                        v-if="$userCaps.hasCapability('tnc_rep_read_logs')"
                        :class="activeRoute == 'CollectionActivitiesPage' ? 'is-active':''"
                        class="level-item"
                        v-tooltip="{
                            delay: {
                                show: 300,
                                hide: 100,
                            },
                            content: $i18n.get('activities'),
                            autoHide: false,
                            placement: 'bottom-start',
                            classes: ['header-tooltips']
                        }">
                    <router-link 
                            tag="a" 
                            :to="{ path: collection && collection.id ? $routerHelper.getCollectionActivitiesPath(collection.id) : '' }"
                            :aria-label="$i18n.get('label_collection_activities')">
                        <span class="icon">
                            <i class="tainacan-icon tainacan-icon-20px tainacan-icon-activities"/>
                        </span>
                        <!-- <span class="menu-text">{{ $i18n.get('activities') }}</span> -->
                    </router-link>                
                </li>
                <li 
                        v-if="collection && collection.current_user_can_edit_users"
                        :class="activeRoute == 'CollectionCapabilitiesPage' ? 'is-active':''"
                        class="level-item"
                        v-tooltip="{
                            delay: {
                                show: 300,
                                hide: 100,
                            },
                            content: $i18n.get('capabilities'),
                            autoHide: false,
                            placement: 'bottom-start',
                            classes: ['header-tooltips']
                        }">
                    <router-link 
                            tag="a" 
                            :to="{ path: collection && collection.id ? $routerHelper.getCollectionCapabilitiesPath(collection.id) : '' }"
                            :aria-label="$i18n.get('label_collection_capabilities')">
                        <span class="icon">
                            <svg
                                    xmlns:dc="http://purl.org/dc/elements/1.1/"
                                    xmlns:cc="http://creativecommons.org/ns#"
                                    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                                    xmlns:svg="http://www.w3.org/2000/svg"
                                    xmlns="http://www.w3.org/2000/svg"
                                    version="1.1"
                                    viewBox="0 0 833 750"
                                    data-name="Camada 1"
                                    id="Camada_1">
                                <defs
                                        id="defs11" />
                                <path
                                        id="path4"
                                        transform="translate(-83.5 -125)"
                                        d="M812.38,125H187.62A103.77,103.77,0,0,0,83.5,229.12V770.88A104.1,104.1,0,0,0,187.62,875H812.38A104,104,0,0,0,916.5,771V229.12A104.12,104.12,0,0,0,812.38,125ZM833.5,792h-666V209h666Z" />
                                <path
                                        id="path6"
                                        transform="translate(-83.5 -125)"
                                        d="M377.5,626a126,126,0,0,0,118.82-84H583.5v83h84V542h83V459H496.67A126,126,0,1,0,377.5,626Zm0-168a42,42,0,1,1-42,42A42,42,0,0,1,377.5,458Z" />
                            </svg>
                        </span>
                        <!-- <span class="menu-text">{{ $i18n.get('activities') }}</span> -->
                    </router-link>                
                </li>
            
            </ul>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    name: 'TainacanCollectionSubheader',
    data(){
        return {
            activeRoute: 'ItemsList',
            pageTitle: '',
            activeRouteName: '',
            childrenBreadCrumbItems: []
        }
    },
    computed: {
        collection() {
            return this.getCollection();
        },
        collectionBreadCrumbItem() {
            return { 
                url: this.collection && this.collection.id ? this.$routerHelper.getCollectionPath(this.collection.id) : '',
                name: this.collection && this.collection.name ? this.collection.name : ''
            };
        }
    },
    watch: {
        '$route' (to, from) {
            if (to.path != from.path) {
                this.activeRoute = to.name;
                this.pageTitle = this.$route.meta.title;
            }
        }
    },
    methods: {
        ...mapGetters('collection', [
            'getCollection'
        ]),
        collectionBreadCrumbUpdate(breadCrumbItems) {
            this.childrenBreadCrumbItems = breadCrumbItems;
        }
    },
    created() {
        this.activeRoute = this.$route.name;

        this.pageTitle = this.$route.meta.title;

        this.$root.$on('onCollectionBreadCrumbUpdate', this.collectionBreadCrumbUpdate);
    },
    beforeDestroy() {
        this.$root.$on('onCollectionBreadCrumbUpdate', this.collectionBreadCrumbUpdate);
    }
}
</script>

<style lang="scss" scoped>

    @import "../../scss/_variables.scss";

    .header-tooltips .tooltip-inner {
        color: turquoise5;
        text-shadow: none;
        background-color: $turquoise2;
        font-size: 0.75rem;
        font-weight: 400;
        padding: 10px 14px;
    }
    .header-tooltips .tooltip-arrow {
        border-color: $turquoise2;
    }
    
    // Tainacan Header
    #tainacan-subheader {
        background-color: $gray1;
        height: $subheader-height;
        max-height: $subheader-height;
        width: 100%;
        padding-top: 18px;
        padding-bottom: 18px;
        padding-right: $page-side-padding;
        padding-left: 0;
        margin: 0px;
        vertical-align: middle; 
        left: 0;
        right: 0;
        z-index: 9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        
        transition: padding 0.3s, height 0.3s;

        h1 {
            font-size: 18px;
            font-weight: 500;
            color: $blue5;
            line-height: 22px;
            margin-bottom: 12px; 
            max-width: 450px;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;  
        }

        .back-button {
            padding: 0;
            margin: 0;
            height: 42px;
            width: $page-side-padding;
            min-width: $page-side-padding;
            background-color: $gray1;
            color: $turquoise4;
            display: flex;

            button, 
            button:hover, 
            button:focus, 
            button:active {
                width: 100%;
                color: $turquoise4;
                background-color: transparent !important;
                border: none;
                height: 42px !important;
                .icon {
                    margin-top: -2px;
                    font-size: 24px;
                }
            }
        }

        .breadcrumbs {
            font-size: 12px;
            line-height: 12px;
            color: #1d1d1d;
            a {
                text-overflow: ellipsis;
                white-space: nowrap;
                overflow: hidden;
                max-width: 115px;
                margin: 0 0.1rem;
                display: inline-block;
                vertical-align: bottom;
            }
        }

        .level {
            width: 100%;
        }

        li {
            margin-right: 0px;
            transition: background-color 0.2s ease;
            // transition: max-width 0.4s ease-in , width 0.4s ease-in ;
            // -webkit-transition: max-width 0.4s ease-in, width 0.4s ease-in ;
            // overflow: hidden;
            // max-width: 50px;

            &.is-active {
                background-color: $turquoise4;
                a { 
                    background-color: $turquoise4;
                    transition: color 0.2s ease;
                    color: white;
                    text-decoration: none;
                }
                svg {
                    fill: white !important;
                }
            }
            &:hover:not(.is-active) {
                // max-width: 100%;
                // transition: max-width 0.4s ease-out  0.2s, width 0.4s ease-out  0.2s;
                // -webkit-transition: max-width 0.4s ease-out  0.2s, width 0.4s ease-out  0.2s;
                a {
                    background-color: transparent;
                    text-decoration: none; 
                    color: $turquoise5;
                }
                svg {
                    fill: $turquoise5;
                }
                // .menu-text {
                //     opacity: 1.0;
                //     width: 100%;
                //     right: 0%;
                //     visibility: visible;
                //     transition: opacity 0.4s ease-out 0.2s, visibility 0.4s ease-out  0.2s, width 0.4s ease-out  0.2s, right 0.4s ease-out  0.2s;
                //     -webkit-transition: opacity 0.4s ease-out  0.2s , visibility 0.4s ease-out  0.2s, width 0.4s ease-out  0.2s, right 0.4s ease-out  0.2s;
                // }
            }
            a {
                color: $gray4;
                text-align: center;
                white-space: nowrap;
                padding: 9px;
                min-width: 50px;
                line-height: 22px;
                border-radius: 0px;
                position: relative;
                align-items: center;
                display: block;
            }
            a:focus{
                box-shadow: none;
            }
            .icon {
                margin: 0;
                padding: 0;
                i {
                    font-size: 18px !important;
                }
                svg {
                    position: relative;
                    top: 1px;
                    height: 18px;
                    fill: #555758;
                }
            }
            .menu-text {
                margin-left: 8px;
                font-size: 14px;
                display: inline-flex;
                // width: 0px;
                // right: 100%;
                // opacity: 0.0;
                // visibility: hidden;
                // transition: opacity 0.4s ease-in, visibility 0.4s ease-in , width 0.2s ease-in, right 0.2s ease-in;
                // -webkit-transition: opacity 0.4s ease-in, visibility 0.4s ease-in, width 0.2s ease-in, right 0.2s ease-in;
            }
        }

        @media screen and (max-width: 769px) {
            width: 100% !important;
            max-width: 100% !important;
            height: 85px;
            max-height: 85px;
            padding: 0;
            top: 206px;
            margin-bottom: 0px !important;
            
            .level-left {
                margin-left: 0px !important;
                display: flex;
                padding: 0 1rem;
                .level-item {
                    display: inline-flex;
                }
            }

            .level-right { 
                margin-top: 0px;
                flex-flow: wrap;
                display: flex;
                align-items: baseline;
                justify-content: space-between;

                .level-item {
                    margin-bottom: 0;
                    a { 
                        padding: 0.5em 0.7em !important; 
                        text-align: center;
                    }
                    .menu-text {
                        display: none;
                    }
                }
            }
        }

        .tooltip.is-primary {
            z-index: 99;
        }
        .tooltip.is-primary::after {
            background-color: $turquoise1;
            color: $turquoise5;
        }
        .tooltip.is-primary::before {
            border-bottom-color: $turquoise1;
        }

    }
</style>



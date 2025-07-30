<template>
    <div class="filter">
        <!-- mobile filter start -->
        <div @click="isFiltersModal = !isFiltersModal" class="filter-modal">
            <div v-if="!filtersResetBtn" class="is-filters"></div>
            <div class="text">Фильтры</div>
            <div class="icon-filter">
                <svg width="16px" height="13px" viewBox="0 0 16 13" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g transform="translate(-466.000000, -378.000000)"> <g transform="translate(466.000000, 378.000000)"> <path d="M0,1.5 L16,1.5" id="Line" stroke="#77797f"/> <path d="M0,6.5 L16,6.5" stroke="#77797f"/> <path d="M0,11.5 L16,11.5" stroke="#77797f"/> <circle fill="#77797f" cx="3.5" cy="1.5" r="1.5"/> <circle fill="#77797f" cx="11.5" cy="6.5" r="1.5"/> <circle id="Oval-Copy-2" fill="#77797f" cx="5.5" cy="11.5" r="1.5"/> </g> </g> </g> </svg>
            </div>
        </div>
        <transition name="fade">
            <div v-if="isFiltersModal" class="filter-overlay"></div>
        </transition>
        <!-- mobile filter end -->
        <!-- desktop filter start-->
            <div class="filter-desktop">
                <div @click.self="showFilterDropdown('sort');" class="section-select">
                    <div class="select-label">{{ selectedSort }}</div>
                    <div class="select-icon" :class="{'select-icon__is-reveal': desktopFilters.sort}"></div>
                    <transition name="fade">
                        <div v-show="desktopFilters.sort" class="dropdown-menu dropdown-menu__sort">
                            <ul class="dropdown-list">
                                <li class="dropdown-item">
                                    <input :id="sort.default.value" type="radio" :value="sort.default.value" v-model="sortPicked" @change="disktopSortItems('sort')">
                                    <div class="checkmark"></div>
                                    <label :for="sort.default.value">{{ sort.default.name }}</label>
                                </li>
                                <li class="dropdown-item">
                                    <input :id="sort.asc.value" type="radio" :value="sort.asc.value" v-model="sortPicked" @change="disktopSortItems('sort')">
                                    <div class="checkmark"></div>
                                    <label :for="sort.asc.value">{{ sort.asc.name }}</label>
                                </li>
                                <li class="dropdown-item">
                                    <input :id="sort.desc.value" type="radio" :value="sort.desc.value" v-model="sortPicked" @change="disktopSortItems('sort')">
                                    <div class="checkmark"></div>
                                    <label :for="sort.desc.value">{{ sort.desc.name }}</label>
                                </li>
                                <li class="dropdown-item">
                                    <input :id="sort.discount.value" type="radio" :value="sort.discount.value" v-model="sortPicked" @change="disktopSortItems('sort')">
                                    <div class="checkmark"></div>
                                    <label :for="sort.discount.value">{{ sort.discount.name }}</label>
                                </li>
                            </ul>
                        </div>
                    </transition>
                </div>
                <!-- sort colors start -->
                <div @click.self="showFilterDropdown('color');" class="section-select" :class="{'is-filters': !colorsResetBtn}">
                    <div class="select-label">Цвет</div>
                    <div class="select-icon" :class="{'select-icon__is-reveal': desktopFilters.color}"></div>
                    <div class="select-reset"></div>
                    <transition name="fade">
                        <div v-show="desktopFilters.color" class="dropdown-menu">
                            <ul class="dropdown-list">
                                <li v-for="color in colors" :key="color.id"  class="dropdown-item dropdown-item__color">
                                    <input :id="color.value + color.id" type="checkbox" :value="color.value" v-model="sortColors">
                                    <div class="checkmark"></div>
                                    <img :src="color.data">
                                    <label :for="color.value + color.id">{{ color.name }}</label>
                                </li>
                            </ul>
                            <div class="dropdown-actions">
                                <button @click="sortColors = []; desktopFilters.color = false; sortCategoryItems(null)" :disabled="colorsResetBtn" class="btn reset">Сбросить</button>
                                <button @click="desktopFilters.color = false; sortCategoryItems(null)" class="btn accept">Применить</button>
                            </div>
                        </div>
                    </transition>
                </div>
                <!-- sort colors end -->
                <!-- sort sizes start -->
                <div @click.self="showFilterDropdown('size');" class="section-select" :class="{'is-filters': !sizesResetBtn}">
                    <div class="select-label">Размер</div>
                    <div class="select-icon" :class="{'select-icon__is-reveal': desktopFilters.size}"></div>
                    <transition name="fade">
                        <div v-show="desktopFilters.size" class="dropdown-menu">
                            <ul class="dropdown-list">
                                <li v-for="sizeType in sizes" :key="sizeType.id"  class="dropdown-item">
                                    <ul class="sizes-list">
                                        <div v-if="sizes.length > 1" class="sizes-list-title">{{ sizeType.title }}</div>
                                        <li v-for="size in sizeType.sizes" :key="size.id" class="sizes-item">
                                            <input :id="size.value + size.id" type="checkbox" :value="size.value" v-model="sortSizes">
                                            <div class="checkmark"></div>
                                            <label :for="size.value + size.id">{{ size.value }}</label>
                                        </li>
                                    </ul>
                                </li>
                                <li v-if="!sizes.length" class="dropdown-item" style="justify-content: center">Нет размеров</li>
                            </ul>
                            <div class="dropdown-actions">
                                <button @click="sortSizes = []; desktopFilters.size = false; sortCategoryItems(null)" :disabled="sizesResetBtn" class="btn reset">Сбросить</button>
                                <button @click="desktopFilters.size = false; sortCategoryItems(null)" class="btn accept">Применить</button>
                            </div>
                        </div>
                    </transition>
                </div>
                <!-- sort sizes end -->
                <!-- sort brands start -->
                <div @click.self="showFilterDropdown('brand');" class="section-select" :class="{'is-filters': !brandsResetBtn}">
                    <div class="select-label">Бренд</div>
                    <div class="select-icon" :class="{'select-icon__is-reveal': desktopFilters.brand}"></div>
                    <transition name="fade">
                        <div v-show="desktopFilters.brand" class="dropdown-menu">
                            <ul class="dropdown-list">
                                <li v-for="brand in brands" :key="brand.id"  class="dropdown-item">
                                    <input :id="brand.value + brand.id" type="checkbox" :value="brand.value" v-model="sortBrands">
                                    <div class="checkmark"></div>
                                    <label :for="brand.value + brand.id">{{ brand.name }}</label>
                                </li>
                            </ul>
                            <div class="dropdown-actions">
                                <button @click="sortBrands = []; desktopFilters.brand = false; sortCategoryItems(null)" :disabled="brandsResetBtn" class="btn reset">Сбросить</button>
                                <button @click="desktopFilters.brand = false; sortCategoryItems(null)" class="btn accept">Применить</button>
                            </div>
                        </div>
                    </transition>
                </div>
                <!-- sort brands end -->
                <!-- sort seasons start -->
                <div @click.self="showFilterDropdown('season');" class="section-select" :class="{'is-filters': !seasonsResetBtn}">
                    <div class="select-label">Сезон</div>
                    <div class="select-icon" :class="{'select-icon__is-reveal': desktopFilters.season}"></div>
                    <transition name="fade">
                        <div v-show="desktopFilters.season" class="dropdown-menu">
                            <ul class="dropdown-list">
                                <li v-for="season in seasons" :key="season.id"  class="dropdown-item">
                                    <input :id="season.value + season.id" type="checkbox" :value="season.value" v-model="sortSeasons">
                                    <div class="checkmark"></div>
                                    <label :for="season.value + season.id">{{ season.name }}</label>
                                </li>
                            </ul>
                            <div class="dropdown-actions">
                                <button @click="sortSeasons = []; desktopFilters.season = false; sortCategoryItems(null)" :disabled="seasonsResetBtn" class="btn reset">Сбросить</button>
                                <button @click="desktopFilters.season = false; sortCategoryItems(null)" class="btn accept">Применить</button>
                            </div>
                        </div>
                    </transition>
                </div>
                 <!-- sort seasons end -->
                <!-- sort prices start -->
                <div @click.self="showFilterDropdown('price');" class="section-select" :class="{'is-filters': !priceResetBtn}">
                    <div class="select-label">Цена</div>
                    <div class="select-icon" :class="{'select-icon__is-reveal': desktopFilters.price}"></div>
                    <transition name="fade">
                        <div v-show="desktopFilters.price" class="dropdown-menu">
                            <div class="range-inputs">
                                <div class="range-label">
                                    <span class="text">От</span>
                                    <input type="text" :value="`${rangeValues[0]} ₸`" readonly>
                                </div>
                                <div class="range-label">
                                    <span class="text">До</span>
                                    <input type="text" :value="`${rangeValues[1]} ₸`" readonly>
                                </div>
                            </div>
                             <div class="range-slider">
                                <vue-slider :dotSize="24" :silent="true" :tooltip="'none'" :min="price.min" :max="price.max" :interval="1" v-model="rangeValues" :width="'85%'"></vue-slider>
                            </div>
                            <div class="dropdown-actions">
                                <button @click="setRangeValues(price.min, price.max);desktopFilters.price = false;sortCategoryItems(null)" :disabled="priceResetBtn" class="btn reset">Сбросить</button>
                                <button @click="desktopFilters.price = false;sortCategoryItems(null)" class="btn accept">Применить</button>
                            </div>
                        </div>
                    </transition>
                </div>
                <!-- sort prices end -->
                <!-- sort branches start -->
                <div @click.self="showFilterDropdown('branch');" class="section-select" :class="{'is-filters': !branchesResetBtn}">
                    <div class="select-label">Филиал</div>
                    <div class="select-icon" :class="{'select-icon__is-reveal': desktopFilters.branch}"></div>
                    <transition name="fade">
                        <div v-show="desktopFilters.branch" class="dropdown-menu">
                            <ul class="dropdown-list">
                                <li v-for="branch in branches" :key="branch.id"  class="dropdown-item">
                                    <input :id="branch.slug + branch.id" type="checkbox" :value="branch.slug" v-model="sortBranches">
                                    <div class="checkmark"></div>
                                    <label :for="branch.slug + branch.id">{{ branch.address }}</label>
                                </li>
                            </ul>
                            <div class="dropdown-actions">
                                <button @click="sortBranches = []; desktopFilters.branch = false; sortCategoryItems(null)" :disabled="branchesResetBtn" class="btn reset">Сбросить</button>
                                <button @click="desktopFilters.branch = false; sortCategoryItems(null)" class="btn accept">Применить</button>
                            </div>
                        </div>
                    </transition>
                </div>
                <!-- sort branches end -->
            </div>
        <!-- desktop filter end -->


        <!-- filters start -->
        <transition name="bottom-fade">
            <div v-show="isFiltersModal" ref="filters" class="filters">
                <div class="filters-modal main-layer">
                    <div @click="isFiltersModal = !isFiltersModal" class="filters-modal__header">
                        <div class="modal-title">Фильтры</div>
                        <div class="modal-close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 20"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/><path d="M0 0h24v24H0z" fill="none"/></svg>
                        </div>
                    </div>
                    <div class="filters-modal__content">
                        <ul class="filters-modal__list">
                            <!-- <li v-if="isGender" class="filters-modal__item">
                                <div class="filters-modal__item-label">
                                    <span>Пол</span>
                                    <div class="segment-control">
                                        <button @click="toggleGender(0, 'all')" class="btn left" :class="{'is-active': activeGenderID === 0}">Все</button>
                                        <button @click="toggleGender(1, 'women')" class="btn center" :class="{'is-active': activeGenderID === 1}">Женщинам</button>
                                        <button @click="toggleGender(2, 'men')" class="btn right" :class="{'is-active': activeGenderID === 2}">Мужчинам</button>
                                    </div>
                                </div>
                            </li> -->
                            <li class="filters-modal__item">
                                <div v-if="!sortResetBtn" @click="sortPicked = 'default'; sortCategoryItems(null)" class="filters-modal__item-clear"></div>
                                <div @click="slideSort.play()"  class="filters-modal__item-label">
                                    <span>Сортировать</span>
                                    <span class="filters-modal__item-values">{{ selectedSort }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M5.88 4.12L13.76 12l-7.88 7.88L8 22l10-10L8 2z"/><path fill="none" d="M0 0h24v24H0z"/></svg>
                                </div>
                            </li>
                            <li class="filters-modal__item">
                                <div v-if="!colorsResetBtn" @click="sortColors = []; sortCategoryItems(null)" class="filters-modal__item-clear"></div>
                                <div @click="slideColor.play()" class="filters-modal__item-label">
                                    <span>Цвет</span>
                                    <span class="filters-modal__item-values">{{ selectedColors }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M5.88 4.12L13.76 12l-7.88 7.88L8 22l10-10L8 2z"/><path fill="none" d="M0 0h24v24H0z"/></svg>
                                </div>
                            </li>
                            <li class="filters-modal__item">
                                <div v-if="!sizesResetBtn" @click="sortSizes = []; sortCategoryItems(null)" class="filters-modal__item-clear"></div>
                                <div @click="slideSize.play()"  class="filters-modal__item-label">
                                    <span>Размер</span>
                                    <span class="filters-modal__item-values">{{ selectedSizes }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M5.88 4.12L13.76 12l-7.88 7.88L8 22l10-10L8 2z"/><path fill="none" d="M0 0h24v24H0z"/></svg>
                                </div>
                            </li>
                            <li class="filters-modal__item">
                                <div v-if="!brandsResetBtn" @click="sortBrands = []; sortCategoryItems(null)" class="filters-modal__item-clear"></div>
                                <div @click="slideBrand.play()"  class="filters-modal__item-label">
                                    <span>Бренд</span>
                                    <span class="filters-modal__item-values">{{ selectedBrands }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M5.88 4.12L13.76 12l-7.88 7.88L8 22l10-10L8 2z"/><path fill="none" d="M0 0h24v24H0z"/></svg>
                                </div>
                            </li>
                            <li class="filters-modal__item">
                                <div v-if="!seasonsResetBtn" @click="sortSeasons = []; sortCategoryItems(null)" class="filters-modal__item-clear"></div>
                                <div @click="slideSeason.play()"  class="filters-modal__item-label">
                                    <span>Сезон</span>
                                    <span class="filters-modal__item-values">{{ selectedSeasons }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M5.88 4.12L13.76 12l-7.88 7.88L8 22l10-10L8 2z"/><path fill="none" d="M0 0h24v24H0z"/></svg>
                                </div>
                            </li>
                             <li class="filters-modal__item">
                                <div v-if="!priceResetBtn" @click="rangeValues = [price.min, price.max]; sortCategoryItems(null)" class="filters-modal__item-clear"></div>
                                <div @click="slidePrice.play()"  class="filters-modal__item-label">
                                    <span>Цена</span>
                                    <div v-if="!priceResetBtn" class="filters-modal__item-values">
                                        <span v-if="rangeValues[0] !== price.min">от {{ parseInt(this.rangeValues[0]).toLocaleString('ru-RU') }} ₸ </span>
                                        <span v-if="rangeValues[1] !== price.max">до {{ parseInt(this.rangeValues[1]).toLocaleString('ru-RU') }} ₸ </span>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M5.88 4.12L13.76 12l-7.88 7.88L8 22l10-10L8 2z"/><path fill="none" d="M0 0h24v24H0z"/></svg>
                                </div>
                            </li>
                            <li class="filters-modal__item">
                                <div v-if="!branchesResetBtn" @click="sortBranches = []; sortCategoryItems(null)" class="filters-modal__item-clear"></div>
                                <div @click="slideBranch.play()"  class="filters-modal__item-label">
                                    <span>Филиал</span>
                                    <span class="filters-modal__item-values">{{ selectedBranches }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M5.88 4.12L13.76 12l-7.88 7.88L8 22l10-10L8 2z"/><path fill="none" d="M0 0h24v24H0z"/></svg>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <transition name="fade">
                        <div v-show="isEmptyItems" ref="isEmptyItems" class="not-found">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                            <div class="text">По вашему запросу ничего не найдено</div>
                            <button @click="isEmptyItems = false; setDataFromQuery()" class="btn">Вернуться к фильтру</button>
                        </div>
                    </transition>
                    <div class="filters-modal__footer">
                        <div class="container">
                            <div class="filters-modal__total-items">Всего {{ calcTotalItems }}</div>
                            <div class="filters-modal__actions">
                                <button @click="filtersResetAll" :disabled="filtersResetBtn" class="btn reset">Сбросить</button>
                                <button @click="isFiltersModal = !isFiltersModal" class="btn accept">Показать</button>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- filter sort start -->
                <div class="filters-modal sort">
                    <div class="filters-modal__wrapper">
                        <div @click="reverseFilterModal(slideSort)" class="filters-modal__header">
                            <div class="modal-title">Сортировка</div>
                            <div class="modal-back">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 7.4 12" style="enable-background:new 0 0 7.4 12;" xml:space="preserve"><path d="M0,10.6L4.6,6L0,1.4L1.4,0l6,6l-6,6L0,10.6z"/></svg>
                            </div>
                        </div>
                        <div class="filters-modal__content">
                            <ul class="filters-modal__list">
                                <li @click="sortPicked = sort.default.value" class="filters-modal__item">
                                    <label :for="sort.default.value">{{ sort.default.name }}</label>
                                    <input :id="sort.default.value" type="radio" :value="sort.default.value" v-model="sortPicked">
                                    <div class="checkmark"></div>
                                </li>
                                <li @click="sortPicked = sort.asc.value" class="filters-modal__item">
                                    <label :for="sort.asc.value">{{ sort.asc.name }}</label>
                                    <input :id="sort.asc.value" type="radio" :value="sort.asc.value" v-model="sortPicked">
                                    <div class="checkmark"></div>
                                </li>
                                <li @click="sortPicked = sort.desc.value" class="filters-modal__item">
                                    <label :for="sort.desc.value">{{ sort.desc.name }}</label>
                                    <input :id="sort.desc.value" type="radio" :value="sort.desc.value" v-model="sortPicked">
                                    <div class="checkmark"></div>
                                </li>
                                <li @click="sortPicked = sort.discount.value" class="filters-modal__item">
                                    <label :for="sort.discount.value">{{ sort.discount.name }}</label>
                                    <input :id="sort.discount.value" type="radio" :value="sort.discount.value" v-model="sortPicked">
                                    <div class="checkmark"></div>
                                </li>
                            </ul>
                        </div>
                        <div class="container">
                            <div class="filters-modal__actions">
                                <button @click="sortPicked = 'default'" :disabled="sortResetBtn" class="btn reset">По умолчанию</button>
                                <button @click="sortCategoryItems(slideSort)" class="btn accept">Применить</button>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- filter sort end -->
            <!-- filter colors start -->
                <div class="filters-modal color">
                    <div class="filters-modal__wrapper">
                        <div @click="reverseFilterModal(slideColor)" class="filters-modal__header">
                            <div class="modal-title">Цвет</div>
                            <div class="modal-back">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 7.4 12" style="enable-background:new 0 0 7.4 12;" xml:space="preserve"><path d="M0,10.6L4.6,6L0,1.4L1.4,0l6,6l-6,6L0,10.6z"/></svg>
                            </div>
                        </div>
                        <div class="filters-modal__content">
                            <ul class="filters-modal__list">
                                <li v-for="color in colors" :key="color.id" class="filters-modal__item">
                                    <img :src="color.data">
                                    <label :for="color.value + color.id">{{ color.name }}</label>
                                    <input :id="color.value + color.id" type="checkbox" :value="color.value" v-model="sortColors">
                                    <div class="checkmark"></div>
                                </li>
                            </ul>
                        </div>
                        <div class="container">
                            <div class="filters-modal__actions">
                                <button @click="sortColors = []" :disabled="colorsResetBtn" class="btn reset">Сбросить</button>
                                <button @click="sortCategoryItems(slideColor)" class="btn accept">Применить</button>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- filter colors end -->
            <!-- filter sizes start -->
                <div class="filters-modal size">
                    <div class="filters-modal__wrapper">
                        <div @click="reverseFilterModal(slideSize)" class="filters-modal__header">
                            <div class="modal-title">Размер</div>
                            <div class="modal-back">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 7.4 12" style="enable-background:new 0 0 7.4 12;" xml:space="preserve"><path d="M0,10.6L4.6,6L0,1.4L1.4,0l6,6l-6,6L0,10.6z"/></svg>
                            </div>
                        </div>
                        <div class="filters-modal__content">
                            <ul class="filters-modal__list">
                                <li v-for="sizeType in sizes" :key="sizeType.id">
                                    <ul>
                                        <div v-if="sizes.length > 1" class="sizes-list-title">{{ sizeType.title }}</div>
                                        <li v-for="size in sizeType.sizes" :key="size.id" class="filters-modal__item">
                                            <label :for="size.value + size.id">{{ size.value }}</label>
                                            <input :id="size.value + size.id" type="checkbox" :value="size.value" v-model="sortSizes">
                                            <div class="checkmark"></div>
                                        </li>
                                    </ul>
                                </li>
                                <li v-if="!sizes.length" class="filters-modal__item" style="justify-content: center">Нет размеров</li>
                            </ul>
                        </div>
                        <div class="container">
                            <div class="filters-modal__actions">
                                <button @click="sortSizes = []" :disabled="sizesResetBtn" class="btn reset">Сбросить</button>
                                <button @click="sortCategoryItems(slideSize)" class="btn accept">Применить</button>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- filter sizes end -->
            <!-- filter brands start -->
                <div class="filters-modal brand">
                    <div class="filters-modal__wrapper">
                        <div @click="reverseFilterModal(slideBrand)" class="filters-modal__header">
                            <div class="modal-title">Бренд</div>
                            <div class="modal-back">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 7.4 12" style="enable-background:new 0 0 7.4 12;" xml:space="preserve"><path d="M0,10.6L4.6,6L0,1.4L1.4,0l6,6l-6,6L0,10.6z"/></svg>
                            </div>
                        </div>
                        <div class="filters-modal__content">
                            <ul class="filters-modal__list">
                                <li v-for="brand in brands" :key="brand.id" class="filters-modal__item">
                                    <label :for="brand.value + brand.id">{{ brand.name }}</label>
                                    <input :id="brand.value + brand.id" type="checkbox" :value="brand.value" v-model="sortBrands">
                                    <div class="checkmark"></div>
                                </li>
                            </ul>
                        </div>
                        <div class="container">
                            <div class="filters-modal__actions">
                                <button @click="sortBrands = []" :disabled="brandsResetBtn" class="btn reset">Сбросить</button>
                                <button @click="sortCategoryItems(slideBrand)" class="btn accept">Применить</button>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- filter brands end -->
            <!-- filter seasons start -->
                <div class="filters-modal season">
                    <div class="filters-modal__wrapper">
                        <div @click="reverseFilterModal(slideSeason)" class="filters-modal__header">
                            <div class="modal-title">Сезон</div>
                            <div class="modal-back">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 7.4 12" style="enable-background:new 0 0 7.4 12;" xml:space="preserve"><path d="M0,10.6L4.6,6L0,1.4L1.4,0l6,6l-6,6L0,10.6z"/></svg>
                            </div>
                        </div>
                        <div class="filters-modal__content">
                            <ul class="filters-modal__list">
                                <li v-for="season in seasons" :key="season.id" class="filters-modal__item">
                                    <label :for="season.value + season.id">{{ season.name }}</label>
                                    <input :id="season.value + season.id" type="checkbox" :value="season.value" v-model="sortSeasons">
                                    <div class="checkmark"></div>
                                </li>
                            </ul>
                        </div>
                        <div class="container">
                            <div class="filters-modal__actions">
                                <button @click="sortSeasons = []" :disabled="seasonsResetBtn" class="btn reset">Сбросить</button>
                                <button @click="sortCategoryItems(slideSeason)" class="btn accept">Применить</button>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- filter seasons end -->
            <!-- filter price start -->
                <div class="filters-modal price">
                    <div class="filters-modal__wrapper">
                        <div @click="reverseFilterModal(slidePrice)" class="filters-modal__header">
                            <div class="modal-title">Цена</div>
                            <div class="modal-back">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 7.4 12" style="enable-background:new 0 0 7.4 12;" xml:space="preserve"><path d="M0,10.6L4.6,6L0,1.4L1.4,0l6,6l-6,6L0,10.6z"/></svg>
                            </div>
                        </div>
                        <div class="filters-modal__content">
                            <ul class="filters-modal__list">
                                <li class="filters-modal__item range">
                                    <div class="range-label">
                                        <span class="text">От</span>
                                        <input type="text" :value="`${rangeValues[0]} ₸`" readonly>
                                    </div>
                                    <div class="range-label">
                                        <span class="text">До</span>
                                        <input type="text" :value="`${rangeValues[1]} ₸`" readonly>
                                    </div>
                                </li>
                                <li class="filters-modal__item">
                                    <div class="range-slider">
                                    	<vue-slider :dotSize="24" :silent="true" :tooltip="'none'" :min="price.min" :max="price.max" :interval="1" v-model="rangeValues" :width="'85%'"></vue-slider>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="container">
                            <div class="filters-modal__actions">
                                <button @click="setRangeValues(price.min, price.max)" :disabled="priceResetBtn" class="btn reset">Сбросить</button>
                                <button @click="sortCategoryItems(slidePrice)" class="btn accept">Применить</button>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- filter price end -->
            <!-- filter branches start -->
                <div class="filters-modal branch">
                    <div class="filters-modal__wrapper">
                        <div @click="reverseFilterModal(slideBranch)" class="filters-modal__header">
                            <div class="modal-title">Филиал</div>
                            <div class="modal-back">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 7.4 12" style="enable-background:new 0 0 7.4 12;" xml:space="preserve"><path d="M0,10.6L4.6,6L0,1.4L1.4,0l6,6l-6,6L0,10.6z"/></svg>
                            </div>
                        </div>
                        <div class="filters-modal__content">
                            <ul class="filters-modal__list">
                                <li v-for="branch in branches" :key="branch.id" class="filters-modal__item">
                                    <label :for="branch.slug + branch.id">{{ branch.address }}</label>
                                    <input :id="branch.slug + branch.id" type="checkbox" :value="branch.slug" v-model="sortBranches">
                                    <div class="checkmark"></div>
                                </li>
                            </ul>
                        </div>
                        <div class="container">
                            <div class="filters-modal__actions">
                                <button @click="sortBranches = []" :disabled="branchesResetBtn" class="btn reset">Сбросить</button>
                                <button @click="sortCategoryItems(slideBranch)" class="btn accept">Применить</button>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- filter branches end -->
            </div>
            <!-- filters end -->
        </transition>
    </div>
</template>

<script>
import { disableBodyScroll, enableBodyScroll, clearAllBodyScrollLocks } from 'body-scroll-lock';
import axios from 'axios';
import NProgress from 'nprogress';
import {TweenMax, Power2, TimelineLite} from "gsap/TweenMax";
import VueSlider from 'vue-slider-component'
import 'vue-slider-component/theme/default.css'
import { EventBus } from '../../event-bus.js';

    export default {
        components: {
            VueSlider,
        },
        data() {
            return {
                sort: {
                    default: {
                        value: 'default',
                        name: 'По популярности'
                    },
                    asc: {
                        value: 'price_asc',
                        name: 'По возрастанию цены'
                    },
                    desc: {
                        value: 'price_desc',
                        name: 'По убыванию цены'
                    },
                    discount: {
                        value: 'discount',
                        name: 'По скидкам'
                    }
                },
                isFiltersModal: false,
                sortPicked: 'default',
                sortColors: [],
                sortSizes: [],
                sortBrands: [],
                sortSeasons: [],
                sortBranches: [],
                filtersResetBtn: true,
                colorsResetBtn: true,
                sizesResetBtn: true,
                brandsResetBtn: true,
                seasonsResetBtn: true,
                sortResetBtn: true,
                priceResetBtn: true,
                branchesResetBtn: true,
                rangeValues: [],
                isEmptyItems: false,
                price: {},
                activeGenderID: 0,
                isGender: Boolean,
                desktopFilters: {
                    sort: false,
                    color: false,
                    size: false,
                    brand: false,
                    season: false,
                    price: false,
                    branch: false
                }
            }
        },
        props: ['colors', 'sizes', 'brands', 'seasons', 'branches', 'dataPrice', 'totalItems', 'isGendersItems'],
        created() {
            this.price = this.dataPrice
            this.isGender = this.isGendersItems
            if (this.$route.query.c) this.activeGenderID = parseInt(this.$route.query.c)
            this.setDataFromQuery()
            // event bus start
            EventBus.$on('setGenderID', newValue => {
                this.activeGenderID = newValue;
            });

            EventBus.$on('setIsEmptyItems', newValue => {
                this.isEmptyItems = newValue;
            });

            EventBus.$on('setGendersSelector', newValue => {
                this.isGender = newValue;
            });
            // event bus end
        },
        mounted() {
            this.filtersWatch()
            console.log(this.$branches)
        },
        methods: {
            setDataFromQuery() {
                if (this.$route.query.price_min) {
                    this.rangeValues.splice(0, 1, JSON.parse(this.$route.query.price_min))
                    this.filtersResetBtn = false
                } else this.rangeValues.splice(0, 1, this.price.min)

                if (this.$route.query.price_max) {
                    this.rangeValues.splice(1, 1, JSON.parse(this.$route.query.price_max))
                    this.filtersResetBtn = false
                } else this.rangeValues.splice(1, 1, this.price.max)

                if (this.$route.query.colors) {
                    this.sortColors = JSON.parse(this.$route.query.colors)
                    this.filtersResetBtn = false
                } else this.sortColors = []

                if (this.$route.query.sizes) {
                    this.sortSizes = JSON.parse(this.$route.query.sizes)
                    this.filtersResetBtn = false
                } else this.sortSizes = []

                if (this.$route.query.brands) {
                    this.sortBrands = JSON.parse(this.$route.query.brands)
                    this.filtersResetBtn = false
                } else this.sortBrands = []

                if (this.$route.query.seasons) {
                    this.sortSeasons = JSON.parse(this.$route.query.seasons)
                    this.filtersResetBtn = false
                } else this.sortSeasons = []

                if (this.$route.query.branches) {
                    this.sortBranches = JSON.parse(this.$route.query.branches)
                    this.filtersResetBtn = false
                } else this.sortBranches = []

                if (this.$route.query.sort) {
                    this.sortPicked = this.$route.query.sort
                    this.filtersResetBtn = false
                } else this.sortPicked = 'default'
            },
            sortCategoryItems(filterModal) {
                this.$emit('sortFilterItems', filterModal, this.activeGenderID)
            },
            reverseFilterModal(filterModal) {
                this.setDataFromQuery()
                filterModal.reverse()
            },
            setPriceValues(price) {
                this.price = price
            },
            setRangeValues(min ,max) {
                this.rangeValues = [min, max]
            },
            getQueryString() {
                let query, newItems, saleItems, outletItems, sizes, brands, colors, seasons, branches, sort, priceMin, priceMax, page
                query = this.$route.query.sale ? query + `&sale=${this.$route.query.sale}` : ""
                newItems = this.$route.query.is_new ? `&is_new=${this.$route.query.is_new}` : ''
                saleItems = this.$route.query.is_discount ? `&is_discount=${this.$route.query.is_discount}` : ''
                outletItems = this.$route.query.is_outlet ? `&is_outlet=${this.$route.query.is_outlet}` : ''
                sizes = this.sortSizes.length !== 0 ? `&sizes=${encodeURIComponent(JSON.stringify(this.sortSizes))}` : ''
                brands = this.sortBrands.length !== 0 ? `&brands=${encodeURIComponent(JSON.stringify(this.sortBrands))}` : ''
                colors = this.sortColors.length !== 0 ? `&colors=${encodeURIComponent(JSON.stringify(this.sortColors))}` : ''
                seasons = this.sortSeasons.length !== 0 ? `&seasons=${encodeURIComponent(JSON.stringify(this.sortSeasons))}` : ''
                branches = this.sortBranches.length !== 0 ? `&branches=${encodeURIComponent(JSON.stringify(this.sortBranches))}` : ''
                priceMin = this.rangeValues[0] !== this.price.min ? `&price_min=${encodeURIComponent(this.rangeValues[0])}` : ''
                priceMax = this.rangeValues[1] !== this.price.max ? `&price_max=${encodeURIComponent(this.rangeValues[1])}` : ''
                sort = this.sortPicked !== 'default' ? `&sort=${encodeURIComponent(this.sortPicked)}` : ''
                query = newItems + saleItems + outletItems + sizes + brands + colors + seasons + branches + sort + priceMin + priceMax
                return query
            },
            filtersResetAll(isSort = true) {
                this.sortColors = []
                this.sortSizes = []
                this.sortBrands = []
                this.sortSeasons = []
                this.sortBranches = []
                this.sortPicked = this.sort.default.value
                this.setRangeValues(this.price.min, this.price.max)
                if (isSort) this.sortCategoryItems(null)
            },
            filtersWatch() {
                this.$watch(app => [app.sortColors, app.sortBrands, app.sortSizes, app.sortSeasons, app.sortBranches, app.sortPicked, app.rangeValues[0], app.rangeValues[1]], filters => {
                    let isDisableResetBtn = true
                    filters.map(filter => {
                        if (filter.length !== 0 && filter !== 'default' && filter !== this.price.min && filter !== this.price.max) isDisableResetBtn = false
                    })
                    this.filtersResetBtn = isDisableResetBtn
                })
            },
            createFilterTimeLine(elm) {
                let tl = new TimelineLite()
                tl
                    .to('.main-layer', 0.4, {x: -80, ease: Power2.easeInOut}, 0)
                    .to(elm, 0.4, {x: 0, ease: Power2.easeInOut}, 0)
                return tl
            },
            toggleGender(id, slug) {
                this.$emit('toggleFilterGender', id, slug)
            },
              // MARK : desktop foo
            showFilterDropdown(key) {
                this.setDataFromQuery();
                for(const i in this.desktopFilters) {
                    i === key ? this.desktopFilters[key] = !this.desktopFilters[key] : this.desktopFilters[i] = false;
                }
            },
            disktopSortItems(key) {
                this.$emit('sortFilterItems', null, this.activeGenderID)
                this.desktopFilters[key] = false
            }
        },
        computed: {
            slideSort() {
                return this.createFilterTimeLine('.sort')
            },
            slideColor() {
                return this.createFilterTimeLine('.color')
            },
            slideSize() {
                return this.createFilterTimeLine('.size')
            },
            slideBrand() {
                return this.createFilterTimeLine('.brand')
            },
            slideSeason() {
                return this.createFilterTimeLine('.season')
            },
            slideBranch() {
                return this.createFilterTimeLine('.branch')
            },
            slidePrice() {
                return this.createFilterTimeLine('.price')
            },
            selectedSizes() {
                return this.sortSizes.sort().join(', ')
            },
            selectedColors() {
                let arr = []
                for (let value of this.sortColors) {
                    let color = this.colors.find(color => color.value === value);
                    if (color) arr.push(color.name)
                }
                return arr.sort().join(', ')
            },
            selectedBrands() {
                let arr = []
                for (let value of this.sortBrands) {
                    let brand = this.brands.find(brand => brand.value === value);
                    if (brand) arr.push(brand.name)
                }
                return arr.sort().join(', ')
            },
            selectedSeasons() {
                let arr = []
                for (let value of this.sortSeasons) {
                    let season = this.seasons.find(season => season.value === value);
                    if (season) arr.push(season.name)
                }
                return arr.sort().join(', ')
            },
            selectedSort() {
                // изменить
                switch(this.sortPicked) {
                case this.sort.default.value: return this.sort.default.name
                    break
                case this.sort.asc.value: return this.sort.asc.name
                    break
                case this.sort.desc.value: return this.sort.desc.name
                    break
                case this.sort.discount.value: return this.sort.discount.name
                    break
                }
            },
            selectedBranches() {
                let arr = []
                for (let value of this.sortBranches) {
                    let branch = this.branches.find(branch => branch.slug === value);
                    if (branch) arr.push(branch.address)
                }
                return arr.sort().join(', ')
            },
            calcTotalItems() {
                let string = ' товаров'
                if (this.totalItems == 1) string = ' товар'
                if (this.totalItems >= 2 && this.totalItems <= 4) string = ' товара'
                return this.totalItems + string
            },
            // getInterval() {
            //     let difference, interval
            //     difference = this.price.max - this.price.min
            //     if (difference < 10000) interval = 1
            //     else if (difference < 200000) interval = 10
            //     else interval = 100
            //     return interval
            // },
        },
        watch: {
            sortColors(newValue) {
                newValue.length === 0 ? this.colorsResetBtn = true : this.colorsResetBtn = false
            },
            sortSizes(newValue) {
                newValue.length === 0 ? this.sizesResetBtn = true : this.sizesResetBtn = false
            },
            sortBrands(newValue) {
                newValue.length === 0 ? this.brandsResetBtn = true : this.brandsResetBtn = false
            },
            sortSeasons(newValue) {
                newValue.length === 0 ? this.seasonsResetBtn = true : this.seasonsResetBtn = false
            },
            sortBranches(newValue) {
                newValue.length === 0 ? this.branchesResetBtn = true : this.branchesResetBtn = false
            },
            sortPicked(newValue) {
                newValue === 'default' ? this.sortResetBtn = true : this.sortResetBtn = false
            },
            rangeValues(newValue) {
                newValue[0] === this.price.min && this.rangeValues[1] === this.price.max ? this.priceResetBtn = true : this.priceResetBtn = false
            },
            isEmptyItems(newValue) {
                newValue ? disableBodyScroll(this.$refs.isEmptyItems) : enableBodyScroll(this.$refs.isEmptyItems);
            }
        }
    }
</script>

<style lang="scss">
@mixin filterModal {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    transform: translateX(105%);
    z-index: 105;
    box-shadow: 0px 0px 5px 0px $grey;
}
.filter {
    @include get-media($laptop, $desktop) {
        width: 75%;
    }
    &-overlay {
       @include overlay;
    }
    &-modal {
        @include get-media($laptop, $desktop) {
            display: none;
        }
        align-items: center;
        display: flex;
        .is-filters {
            width: 10px;
            height: 10px;
            background:$red;
            border-radius: 5px;
            margin-right: 5px;
        }
        .icon-filter {
            margin-top: 3px;
        }
    }
    .filters {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 103;
        background: white;
        overflow-y: scroll;
        overflow-x: hidden;
        -webkit-overflow-scrolling: touch;
        .main-layer {
            z-index: 104;
        }
        .sort, .color, .size, .brand, .season, .branch {
            @include customInputPicker;
            @include filterModal;
        }
        .price {
            @include filterModal;
        }
        &-modal {
            display: flex;
            flex-direction: column;
            background: white;
            height: 100%;
            &__wrapper {
                height: 100%;
                overflow: hidden;
            }
            &__header {
                @include modalHeader
            }
            &__content {
                height: calc(100% - 160px);
                flex: 1;
                overflow-y: scroll;
                -webkit-overflow-scrolling: touch;
            }
            &__list {
                padding-bottom: 15vh;
                .sizes {
                    &-list-title {
                        text-align: center;
                        border-bottom: 1px solid $line-color;
                        padding: 0.8em 0;
                        text-transform: uppercase;
                        background: #f8f8f8;
                    }
                }
            }
            &__actions {
                width: 100%;
                display: flex;
                align-self: flex-end;
                justify-content: space-between;
                margin: 20px 0;
                @include button(47%);
            }
            &__total-items {
                text-align: center;
                margin-top: 14px;
            }
            &__item {
                position: relative;
                user-select: none;
                @include tableRowStyle;
                border-top: none;
                border-bottom: 1px solid $line-color;
                svg {
                    width: 18px;
                    height: 18px;
                    fill: $grey;
                }
                img {
                    height: 30px;
                    padding-right: 10px;
                }
                &-values {
                    font-size: 80%;
                    color: $grey;
                    flex: 1;
                    margin-left: 10px;
                    white-space: nowrap;
                    overflow: hidden;
                    font-family: SegoeUI;
                    text-overflow: ellipsis;
                }
                &-clear {
                    position: relative;
                    height: 23px;
                    flex: 0 0 23px;
                    background: $red;
                    border-radius: 12px;
                    margin-right: 10px;
                    &::after{
                        content: "";
                        position: absolute;
                        left: 6px;
                        top: 11px;
                        width: 11px;
                        height: 1px;
                        background: white
                    }
                }
                &-label {
                    display: flex;
                    width: 100%;
                    align-items: center;
                    justify-content: space-between;
                    overflow: hidden;
                    height: 100%;
                }

            }
            &__footer {
                padding-bottom: 2.15rem;
            }
           .range {
                height: 70px;
                .range-label {
                    width: 47%;
                    display: flex;
                    align-items: center;
                    .text {
                        margin-right: 7px;
                    }
                    input {
                        padding: 0 .5em;
                    }
                }
                &-slider {
                    display: flex;
                    justify-content: center;
                    width: 100%;
                    .vue-slider-process {
                        background-color: $btn-color;
                    }
                }
            }
            .not-found {
                position: absolute;
                width: 100vw;
                height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                background-color: white;
                padding-top: 22vh;
                svg {
                    width: 20vw;
                    height: 20vw;
                    fill: $yellow-color;
                }
                @include button(90vw);
                .text {
                    margin: 50px 0;
                    font-weight: bold;
                    text-align: center;
                }
            }
        }
    }
    .segment {
        &-control {
            display: flex;
            align-items: center;
            font-family: SegoeUI;
            font-size: 80%;
            @include button;
            .btn {
                padding: 8px;
                background: transparent;
                color: $main-color;
                border: 1px solid $line-color;
            }
            .left {
                border-right: transparent;
                border-top-right-radius: 0;
                border-bottom-right-radius: 0;
            }
            .right {
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
            }
            .center {
                border-radius: 0;
            }
            .is-active {
                background: $donato-color;
                color: white;
                border-color: $donato-color;
            }
        }
    }

    &-desktop {
        display: flex;
        // width: 100%;
        @include get-media($mobile) {
            display: none;
        }
        .section {
            &-select {
                position: relative;
                margin-right: 0.5em;
                border: 1px solid $line-color;
                border-radius: $btn-radius;
                padding: .3em .5em;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                background-color: white;
                transition: background-color .3s;
                .select {
                    &-label {
                        pointer-events: none;
                    }
                    &-icon {
                        @include plusIcon;
                        pointer-events: none;
                        &__is-reveal {
                            &::before {
                                transform: scale(0);
                            }
                        }
                    }
                }
                .dropdown {
                    &-menu {
                        position: absolute;
                        top: 180%;
                        // left: 0;
                        min-width: 100%;
                        background: white;
                        z-index: 10;
                        box-shadow: 0 1px 8px rgba(0,0,0,.25);
                        border-bottom-right-radius: $btn-radius;
                        border-bottom-left-radius: $btn-radius;
                        &::before {
                            content: '';
                            display: block;
                            position: absolute;
                            top: -10px;
                            left: 50%;
                            background: 0 0;
                            width: 0;
                            height: 0;
                            border-bottom: 20px solid #fff;
                            border-right: 20px solid transparent;
                            border-left: 20px solid transparent;
                            margin-left: -20px;
                        }
                        &::after{
                            content: '';
                            z-index: -1;
                            display: block;
                            width: 6px;
                            height: 6px;
                            position: absolute;
                            top: -4px;
                            left: 50%;
                            margin-left: -3px;
                            border-radius: 100%;
                            box-shadow: 0 -2px 8px 1px rgba(0,0,0,.25);
                        }
                        &__sort {
                            left: 0;
                        }
                        .range {
                            &-inputs {
                                display: flex;
                                justify-content: space-between;
                                padding: 1em;
                                width: 260px;
                            }
                            &-label {
                                width: 47%;
                                display: flex;
                                align-items: center;
                                .text {
                                    margin-right: 7px;
                                }
                                input {
                                    padding: 0 .5em;
                                }
                            }
                            &-slider {
                                display: flex;
                                justify-content: center;
                                width: 100%;
                                .vue-slider-process {
                                    background-color: $btn-color;
                                }
                            }
                        }
                    }
                    &-list {
                        max-height: 400px;
                        min-width: 260px;
                        overflow-y: auto;
                        padding: .5em 0;
                    }
                    &-item {
                        position: relative;
                        display: flex;
                        align-items: center;
                        padding: .5em 1em;
                        white-space: nowrap;
                        cursor: default;
                        @include customInputPicker;
                        .checkmark {
                            margin-right: 1em;
                        }
                        &__color {
                            img {
                                width: 20px;
                                height: 100%;
                                margin-right: 5px;
                            }
                        }
                        .sizes {
                            &-list {
                                width: 1000%;
                                &-title {
                                    text-align: center;
                                    margin-bottom: 0.5em;
                                    padding-bottom: 0.5em;
                                    text-transform: uppercase;
                                    border-bottom: 1px solid $line-color;
                                }
                            }
                            &-item {
                                position: relative;
                                display: flex;
                                align-items: center;
                                padding: .5em 1em;
                                white-space: nowrap;
                                cursor: default;
                            }
                        }
                    }
                    &-actions {
                        display: flex;
                        padding: 1em;
                        justify-content: space-between;
                        @include button(48%);
                        .btn {
                            padding: 0.5em 0 !important;
                        }
                    }
                }
                &.is-filters {
                    background-color: $donato-color;
                    .select {
                        &-label {
                            color: white;
                        }
                        &-icon {
                            &::before, &::after {
                                border-color: white;
                            }
                        }
                    }
                }
            }
        }
    }
}
// favorite fade
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.2s;
}
.fade-enter, .fade-leave-to {
    opacity: 0;
}
// filter modal fade
.bottom-fade-enter-active, .bottom-fade-leave-active {
    transition: all 0.35s ease;
}
.bottom-fade-enter, .bottom-fade-leave-to {
    transform: translateY(100%);
}
</style>

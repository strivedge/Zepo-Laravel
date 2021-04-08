<template>

    <div :class="`row mb15 col-12 ${rowClass}`">
        <div class="col-12 no-padding" v-if="tabs || viewAll || scrollable">
            <h2 class="">{{ headerHeading }}</h2>
        </div>

        <div class="col-12 no-padding" v-else >
            <h2 class="">{{ headerHeading }}</h2>
        </div>

        
    </div>

</template>

<script type="text/javascript">
    export default {
        props: [
            'showTabs',
            'rowClass',
            'heading',
            'viewAll',
            'scrollable'
        ],

        data: function () {
            var tabs = null;

            if (this.showTabs) {
                tabs = [
                    'Fashion',
                    'Accessories',
                    'Electronis',
                    'Electronis1',
                    'Electronis2',
                ];
            }

            return {
                tabs: tabs,
                headerHeading: this.heading ? this.heading : this.__('products.text'),
            }
        },

        methods: {
            'switchTab': function ({target}) {
                let clickedTab = target.closest('h2.tab');

                if (clickedTab) {
                    let tabsCollection = this.$el.querySelectorAll('.tab');

                    Array.from(tabsCollection).forEach(tab => {
                        tab.classList.remove('active');
                    });

                    clickedTab.classList.add('active');
                }
            },

            navigation: function (navigateTo) {
                let navigation = $(`#${this.scrollable} .VueCarousel-navigation .VueCarousel-navigation-${navigateTo}`);

                if (navigation && (navigation = navigation[0])) {
                    navigation.click();
                }
            }
        },
    }
</script>
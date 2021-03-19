<header class="sticky-header navbar-middle">
    <div class="container">
        <div class="navbar-middle-wrapper remove-padding-margin velocity-divide-page">
            <logo-component></logo-component>
            <searchbar-component></searchbar-component>
            <!-- <div slot="body">
                    <linked-products></linked-products>
            </div> -->
        </div>
    </div>
</header>
<?php $product = [] ?>

@push('scripts')
    <script type="text/javascript">
        (() => {
            document.addEventListener('scroll', e => {
                scrollPosition = Math.round(window.scrollY);

                if (scrollPosition > 50){
                    document.querySelector('header').classList.add('header-shadow');
                } else {
                    document.querySelector('header').classList.remove('header-shadow');
                }
            });
        })()
    </script>
 
@endpush

<style>
.ruby-global-loader.loader {
        width: fit-content;
        height: auto;
        position: relative;
        display: inline-block;
        text-align: left;
        font-weight: 700;
        font-family: sans-serif;
        font-size: 30px;
        line-height: 1.2;
        color: #d71920;
        padding-bottom: 8px;
        background: linear-gradient(currentColor 0 0) 0 100% / 0% 3px no-repeat;
        animation: l2 2s linear infinite;
        text-align: left;
    }

    .ruby-global-loader.loader::before {
        content: "Loading...";
    }

    @keyframes l2 {
        to { background-size: 100% 3px; }
    }

    #preloader-active {
        position: fixed;
        inset: 0;
        z-index: 9999999;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
    }

    .list-content-loading,
    .tab-content > .loading-spinner,
    .category-products__content > .loading-spinner {
        align-items: center;
        justify-content: center;
    }

    .list-content-loading .ruby-global-loader.loader,
    .loading-spinner .ruby-global-loader.loader {
        font-size: 22px;
    }

    @media (max-width: 575px) {
        .ruby-global-loader.loader {
            font-size: 24px;
        }
    }
</style>

<div id="preloader-active" aria-live="polite" aria-busy="true">
    <div class="ruby-global-loader loader" role="status"></div>
</div>

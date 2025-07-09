<form id="tmdb-search-form" class="row g-3 justify-content-center mb-3 mt-4 mx-auto text-center" style="max-width: 800px;">
    <h4 class="text-center text-white my-2">Потърси онлайн</h4>

    <div class="col-12 col-md-9">
        <input type="text" id="tmdb-query" class="form-control rounded-pill" placeholder="Търси заглавие..." required>
    </div>
    <div class="col-12 col-md-auto">
        <button type="button" id="search-button" class="btn btn-outline-primary rounded-pill px-5">Търси</button>
    </div>
    <div id="spinner" class="text-center mt-2" style="display: none;">
        <img src="{$base_url}/misc/catWhiteNoBG.gif" alt="Зареждане..." width="100">
    </div>
</form>

<div id="search-results" class="text-white text-center"></div>

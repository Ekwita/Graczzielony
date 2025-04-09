<script setup>
</script>

<template>
    <footer>
        <div class="info">
            Wszystkie gry pochodzą z serwisu
            <a href="https://boardgamegeek.com/" class="bgg_link" target="_blank" rel="noopener noreferrer">
                BoardGameGeek
            </a>.
            <br />Wszelkie prawa do gier należą do ich wydawców.
        </div>
        <div class="bgg_logo">
            <a href="https://boardgamegeek.com/" class="bgg_link" target="_blank" rel="noopener noreferrer">
                <img src="/img/BGGLogo.png" alt="BoardGameGeek Logo" class="logo" />
            </a>
        </div>
    </footer>
</template>

<style scoped>
footer {
    background: #333;
    color: #fff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 30px;
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.2);
    width: 100%;
}

.info {
    font-size: 14px;
    line-height: 1.4;
    max-width: 70%;
}

.bgg_logo {
    height: 40px;
    display: flex;
    align-items: center;
}

.logo {
    max-height: 40px;
    height: auto;
    width: auto;
    object-fit: contain;
}

.bgg_link {
    color: #ffd700;
    text-decoration: underline;
}

.bgg_link:hover {
    text-decoration: none;
    color: #ffa500;
}
</style>

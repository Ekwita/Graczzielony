<script setup>
</script>

<template>
    <footer>
        <div class="info">
            <div class="bgg_logo">
                <a href="https://boardgamegeek.com/" class="bgg_link" target="_blank" rel="noopener noreferrer">
                    <img src="/img/BGGLogo.png" alt="BoardGameGeek Logo" class="logo" />
                </a>
            </div>
            <div class="text">
                Wszystkie gry pochodzą z serwisu
                <a href="https://boardgamegeek.com/" class="bgg_link" target="_blank" rel="noopener noreferrer">
                    BoardGameGeek
                </a>.
                <br />Wszelkie prawa do gier należą do ich wydawców.
            </div>
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
    display: flex;
    align-items: left;
    width: 100%;
    padding: 5px;
}

.bgg_logo {
    margin-right: 10px;
    height: 40px;
    display: flex;
    align-items: center;
}

.text {
    font-size: 14px;
    line-height: 1.4;
    max-width: 70%;
    margin-left: 10px;
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

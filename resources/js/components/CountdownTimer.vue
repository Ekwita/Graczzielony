<script setup>
import { ref, onMounted, watchEffect } from 'vue';

const calculateTimeLeft = () => {
    const now = new Date();
    const currentMonth = now.getMonth();
    const currentYear = now.getFullYear();

    const nextMonthDate = new Date(currentYear, currentMonth + 1, 1, 0, 0, 0);

    const timeDifference = nextMonthDate - now;

    const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
    const hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

    return { days, hours, minutes, seconds };
};

const timeLeft = ref(calculateTimeLeft());

const updateTime = () => {
    timeLeft.value = calculateTimeLeft();
};

onMounted(() => {
    const interval = setInterval(updateTime, 1000);

    watchEffect(() => {
        return () => clearInterval(interval);
    });
});
</script>

<template>
    <div class="countdown-timer">
        <p>Do zakończenia głosowania pozostało:</p>
        <div class="time-display">
            <div class="time-item">
                <span class="time-number">{{ timeLeft.days }}</span>
                <span class="time-label">Dni</span>
            </div>
            <div class="time-item">
                <span class="time-number">{{ timeLeft.hours }}</span>
                <span class="time-label">Godziny</span>
            </div>
            <div class="time-item">
                <span class="time-number">{{ timeLeft.minutes }}</span>
                <span class="time-label">Minuty</span>
            </div>
            <div class="time-item">
                <span class="time-number">{{ timeLeft.seconds }}</span>
                <span class="time-label">Sekundy</span>
            </div>
        </div>
    </div>
</template>

<style scoped>
.countdown-timer {
    font-family: Arial, sans-serif;
    text-align: center;
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    max-width: 40%;
    margin: auto;
    margin-top: 30px;

}

.time-display {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 20px;
}

.time-item {
    font-size: 24px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.time-number {
    font-size: 36px;
    font-weight: bold;
    color: #333;
}

.time-label {
    font-size: 14px;
    color: #888;
}
</style>

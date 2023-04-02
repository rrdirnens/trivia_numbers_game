<template>
    <div>
        <h1>Trivia Game</h1>
        <div>
            Current score is: {{ score }}
        </div>
        <div v-if="gameState === 'playing'">
            <p>{{ question }}</p>
            <ul>
                <li v-for="(option, index) in options" :key="index" @click="selectAnswer(option)">
                    {{ option }}
                </li>
            </ul>
        </div>
        <div v-else>
            <p>Game Over. Your score is: {{ score }}</p>
            <button @click="startGame">Restart</button>
        </div>
    </div>
</template>
  
<script>
import { computed, ref } from 'vue';
import { useTriviaStore } from '../stores/trivia';

export default {
    setup() {
        const store = useTriviaStore();
        const gameState = ref('playing');
        const score = ref(0);

        const question = computed(() => store.currentQuestion);
        const options = computed(() => store.currentOptions);
        const correctOption = computed(() => store.currentCorrectOption);

        const fetchQuestion = async () => {
            await store.fetchQuestion();
        };

        const selectAnswer = (selectedOption) => {
            if (selectedOption === correctOption.value) {
                score.value++;
                if (score.value === 20) {
                    gameState.value = 'gameOver';
                } else {
                    fetchQuestion();
                }
            } else {
                gameState.value = 'gameOver';
            }
        };

        const startGame = () => {
            gameState.value = 'playing';
            score.value = 0;
            fetchQuestion();
        };

        fetchQuestion();

        return {
            gameState,
            score,
            question,
            options,
            correctOption,
            fetchQuestion,
            selectAnswer,
            startGame,
        };
    },
}
</script>
  
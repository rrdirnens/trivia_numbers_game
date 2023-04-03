<template>
    <div class="game">
        <h1>Trivia Game</h1>
        <div v-if="loading">
            <p>Loading the question...</p>
        </div>
        <div class="error" v-if="errorMessage">
            <span>
                {{ errorMessage }}
            </span>
            <button @click="startGame">
                Try again?
            </button>
        </div>
        <div v-if="isPlaying && !loading">
            <p class="question">{{ question }}</p>
            <ul class="options">
                <li v-for="(option, index) in options" :key="index" @click="selectAnswer(option)">
                    {{ option }}
                </li>
            </ul>
        </div>
        <div v-if="isGameOver && !lastQuestion" class="game-over__last">
            <p class="game_over">You win! Your score is: {{ score }}</p>
            <button @click="startGame">Restart</button>
        </div>
        <div v-if="isGameOver && lastQuestion" class="game-over__last">
            <p class="game_over">GAME OVER! Your score is: {{ score }}</p>
            <p class="last_question">Last question: <br> {{ lastQuestion }}</p>
            <p class="correct_answer">Correct answer: <span>{{ correctAnswer }}</span></p>
            <p class="your_answer">Your answer: <span>{{ selectedAnswer }}</span></p>
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
        const loading = ref(false);

        const isPlaying = computed(() => gameState.value === 'playing');
        const isGameOver = computed(() => gameState.value === 'gameOver');


        const lastQuestion = ref('');
        const correctAnswer = ref(null);
        const selectedAnswer = ref(null);

        const score = ref(0);

        const question = computed(() => store.currentQuestion);
        const options = computed(() => store.currentOptions);
        const correctOption = computed(() => store.currentCorrectOption);
        const errorMessage = computed(() => store.errorMessage);

        const fetchQuestion = async () => {
            loading.value = true;
            while (true) {
                await store.fetchQuestion();           
                const questionKey = `${store.currentQuestion}-${store.currentCorrectOption}`;
                if (!store.askedQuestions.has(questionKey)) {
                    store.askedQuestions.add(questionKey);
                    break;
                }
            }
            loading.value = false;
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
                lastQuestion.value = question.value;
                correctAnswer.value = correctOption.value;
                selectedAnswer.value = selectedOption;
                gameState.value = 'gameOver';
            }
        };

        const startGame = () => {
            gameState.value = 'playing';
            lastQuestion.value = '';
            score.value = 0;
            store.resetError();
            store.clearAskedQuestions();
            fetchQuestion();
        };

        fetchQuestion();

        return {
            gameState,
            loading,
            score,
            question,
            options,
            errorMessage,
            lastQuestion,
            correctAnswer,
            selectedAnswer,
            isPlaying,
            isGameOver,
            fetchQuestion,
            selectAnswer,
            startGame,
        };
    },
}
</script>
  
<style scoped>
.game {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
}

.game .question {
    margin-bottom: 20px;
    font-size: large;
    text-align: center;
    color: #eee;
}

.game h1 {
    margin-bottom: 20px;
    color: #eee;
}

.game .options {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-gap: 10px;
    list-style: none;
    padding: 0;
}

.game .options li {
    padding: 10px;
    background-color: #eee;
    border-radius: 5px;
    cursor: pointer;
    text-align: center;
    color: #000;
    font-weight: 700;
}

.game .options li:hover {
    background-color: #ddd;
    cursor: pointer;
}

.game .last_question,
.game .correct_answer,
.game .your_answer {
    margin-bottom: 20px;
    color: #eee;
    font-size: large;
    text-align: center;
}

.game .correct_answer span {
    color: rgb(165, 255, 165);
}

.game .your_answer span {
    color: rgb(255, 155, 155);
}

.game .game_over {
    margin-bottom: 20px;
    color: #eee;
    font-size: 30px;
}

.game button {
    padding: 10px;
    background-color: #eee;
    border-radius: 5px;
    cursor: pointer;
    text-align: center;
    color: #000;
    font-weight: 700;
    margin-bottom: 20px;
}

.game .game-over__container,
.game .game-over__last {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
}

.error {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.error span {
    margin-bottom: 10px;
    color: red;
    font-weight: 800;
}
</style>
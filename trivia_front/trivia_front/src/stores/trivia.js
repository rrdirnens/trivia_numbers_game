import { defineStore } from 'pinia';


export const useTriviaStore = defineStore({
  id: 'trivia',
  state: () => ({
    currentQuestion: '',
    currentOptions: [],
    currentCorrectOption: null,
  }),
  actions: {
    async fetchQuestion() {
      try {
        const API_BASE_URL = import.meta.env.VITE_LARAVEL_API_ENDPOINT;
        const response = await fetch(API_BASE_URL);
        if (response.ok) {
          const data = await response.json();
          this.currentQuestion = data.question;
          this.currentOptions = data.options;
          this.currentCorrectOption = data.correctOption;
        } else {
          throw new Error('Failed to fetch trivia question');
          // Handle the error accordingly (e.g. show a notification)
        }
      } catch (error) {
        console.error('Error fetching trivia question:', error);
        // Handle the error accordingly (e.g. show a notification)
      }
    },
  },
});
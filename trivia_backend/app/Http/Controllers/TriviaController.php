<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class TriviaController extends Controller
{
    // This function fetches a trivia question from numbersapi.com
    public function getQuestion()
    {
        $client = new Client();

        try {

            $response = $client->get('http://numbersapi.com/random?json&min=1&max=100000');
            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['number']) && isset($data['text'])) {
                $correctAnswer = $data['number'];
                $triviaText = $data['text'];
                $question = $this->replaceNumberWithBlank($triviaText, $correctAnswer);
                $wrongAnswers = $this->generateWrongAnswers($correctAnswer);
                $options = $this->shuffledOptions($correctAnswer, $wrongAnswers);

                return response()->json([
                    'question' => $question,
                    'options' => $options,
                    'correctOption' => $correctAnswer,
                ]);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch trivia question',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch trivia question',
            ], 500);
        }
    }

    // This function generates 3 wrong answers based on the correct answer
    private function generateWrongAnswers($correctAnswer)
    {
        $wrongAnswers = [];
        $iterations = 0;
        $maxIterations = 100; // This is to prevent an infinite loop. If the loop runs 100 times, it will stop. Although this is very unlikely to happen at this point, because the correct answer is always between 1 and 100000. But just in case.

        while (count($wrongAnswers) < 3 && $iterations < $maxIterations) {

            $min = (int) max(1, $correctAnswer - 10);
            $max = (int) ($correctAnswer + 10);

            $randomAnswer = mt_rand($min, $max);

            if ($randomAnswer !== $correctAnswer && !in_array($randomAnswer, $wrongAnswers)) {
                $wrongAnswers[] = $randomAnswer;
            }

            $iterations++;
        }

        return $wrongAnswers;
    }

    // This function replaces the number in the trivia text with a blank
    public function replaceNumberWithBlank($triviaText, $correctAnswer)
    {
        $correctAnswerString = strval($correctAnswer);

        $triviaText = str_replace($correctAnswerString, '_____', $triviaText);

        return $triviaText;
    }

    // This function shuffles the options
    public function shuffledOptions($correctAnswer, $wrongAnswers)
    {
        $options = array_merge([$correctAnswer], $wrongAnswers);
        
        shuffle($options);

        return $options;
    }
}

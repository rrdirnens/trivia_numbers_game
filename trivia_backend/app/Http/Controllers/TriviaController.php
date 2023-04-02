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

            $response = $client->get('http://numbersapi.com/random/trivia?json');
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

        while (count($wrongAnswers) < 3) {
            $randomAnswer = rand(max(1, $correctAnswer - 10), $correctAnswer + 10);

            if ($randomAnswer !== $correctAnswer && !in_array($randomAnswer, $wrongAnswers)) {
                $wrongAnswers[] = $randomAnswer;
            }
        }

        return $wrongAnswers;
    }

    // This function replaces the number in the trivia text with a blank
    public function replaceNumberWithBlank($triviaText, $correctAnswer)
    {
        $triviaText = str_replace($correctAnswer, '_____', $triviaText);

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
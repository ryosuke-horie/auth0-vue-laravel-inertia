<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Staff\StaffRepositoryInterface;
use App\Repositories\UserTip\UserTipRepositoryInterface;
use GuzzleHttp\Client;

class ChatGPTService
{
    private $staffRepository;
    private $userTipRepository;

    public function __construct(
        StaffRepositoryInterface $staffRepository,
        UserTipRepositoryInterface $userTipRepository
    ) {
        $this->staffRepository = $staffRepository;
        $this->userTipRepository = $userTipRepository;
    }

    /**
     * ユーザーが贈る応援メッセージ取得API
     * @param int $staffId
     * @param int $promptId
     * @return array
     */
    public function userMessage(int $staffId, int $promptId): array
    {
        $messages = $this->getMessagesForUser($staffId, $promptId);
        $responseMessage = $this->chatGPT($messages);

        $args = [
            'message' => $responseMessage,
        ];

        return $args;
    }

    /**
     * スタッフが返信するメッセージ取得API
     * @param int $tipId
     * @param int $promptId
     * @return array $args
     */
    public function staffReply(int $tipId, int $promptId): array
    {
        $messages = $this->getMessagesForStaff($tipId, $promptId);
        $responseMessage = $this->chatGPT($messages);

        $this->userTipRepository->decrementAiCountByStaffIdTipId($tipId);
        $userTip = $this->userTipRepository->findByTipId($tipId);

        $args = [
            'message' => $responseMessage,
            'aiCount'   => $userTip->ai_count,
        ];

        return $args;
    }

    /**
     * CHATGPT API
     * @param array $messages
     * @return string
     */
    private function chatGPT(array $messages): string
    {
        $apiKey = config('app.chatgpt_api_key');
        $endpoint = 'https://api.openai.com/v1/chat/completions';

        $client = new Client();

        $response = $client->post($endpoint, [
            'headers' => [
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer ' . $apiKey,
            ],
            'json'    => [
                'model'    => 'gpt-3.5-turbo',
                'messages' => $messages
            ],
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        $message = $result['choices'][0]['message']['content'];

        return $message;
    }

    /**
     * ChatGPTに投げるプロンプトを取得
     * @param int $promptId
     * @return array
     */
    private function getMessagesForUser(int $staffId, int $promptId): array
    {
        $staff = $this->staffRepository->findByStaffId($staffId);
        $staffName = $staff->staff_name;

        $responseType = '';
        switch ($promptId) {
            case 1:
                $responseType = '大人びた感じ';
                break;
            case 2:
                $responseType = '楽しく盛り上げた感じ';
                break;
            case 3:
                $responseType = '礼儀正しい感じ';
                break;
        }

        $prompt = <<< EOD
        {$staffName}さんに対して、応援を含めチップを送ります。
        そのチップに対して、{$responseType}で、200文字以下で応援メッセージ」を教えて下さい。
        EOD;

        return [
            ["role" => "user", "content" => $prompt]
        ];
    }

    /**
     * ChatGPTに投げるプロンプトを取得
     * @param int $tipId
     * @param int $promptId
     * @return array
     */
    private function getMessagesForStaff(int $tipId, int $promptId): array
    {
        $tip = $this->userTipRepository->findByTipId($tipId);
        $nickname = $tip->user->nickname;
        $point = $tip->tipping_amount;
        $message = $tip->message;

        $responseType = '';
        switch ($promptId) {
            case 1:
                $responseType = '大人びた感じ';
                break;
            case 2:
                $responseType = '楽しく盛り上げた感じ';
                break;
            case 3:
                $responseType = '礼儀正しい感じ';
                break;
        }

        $prompt = <<< EOD
        あなたは「{$nickname}さん」から、「{$message}」というメッセージと一緒に「{$point}円」のチップを頂きました。
        そのチップに対して、{$responseType}で、100文字以下の返信メッセージを教えてください。
        EOD;

        return [
            ["role" => "user", "content" => $prompt]
        ];
    }
}

<?php

namespace App\UseCases\BusinessOperator\Mypage;

use App\Models\Notification;
use App\Models\PrivateNotification;
use App\Enums\EntityType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Index
{
    public function __invoke()
    {

        $args = [];

        // 現在日時取得
        $nowDate = Carbon::now();

        // 事業者名設定
        $args['businessName'] = Auth::guard('business-operator')->user()->business_name;

        // 全体お知らせ取得用条件設定
        $wholeNotificationsWhere = [
            ['entity_type','=',EntityType::BusinessOperator->value],
            ['start_at','<=',$nowDate],
            ['end_at','>=',$nowDate],
        ];

        // 全体お知らせ取得
        $wholeNotifications = Notification::selectRaw(
            "notification_id,
             title,
             start_at,
             file_type,
             file_name,
             'whole' as type"
        )
        ->where($wholeNotificationsWhere)
        ->get();

        // 個人お知らせ取得用条件設定
        $privateNotificationsWhere = [
            ['entity_type','=',EntityType::BusinessOperator->value],
            ['entity_id','=',Auth::guard('business-operator')->user()->business_id],
            ['start_at','<=',$nowDate],
            ['end_at','>=',$nowDate],
        ];

        // 個人お知らせ取得
        $privateNotifications = PrivateNotification::selectRaw(
            "notification_id,
            title,
            start_at,
            is_read,
            'private' as type"
        )
        ->where($privateNotificationsWhere)
        ->get();

        // お知らせ情報のマージ
        $notifications = $wholeNotifications->mergeRecursive($privateNotifications)->sortByDesc('date');

        // データの調整
        $notifications = $notifications->flatten(1)->map(function ($notification) {

            // 全体お知らせの調整
            if ($notification['type'] == 'whole') {
                // 既読情報取得
                $readCount = $notification->notification_reads()
                ->where('entity_id', Auth::guard('business-operator')->user()->business_id)
                ->count();
                $notification['is_read'] = !!$readCount;

                // ファイルがPDFだった場合
                if ($notification->file_type == 'pdf') {
                }
            }

            // お知らせ詳細のURL設定
            $url = route('business-operator.notification.show', ['notificationId' => $notification->notification_id]);

            return [
                'notificationId'    => $notification['notification_id'],
                'title'             => $notification['title'],
                'date'              => $notification['start_at']->format('Y-m-d'),
                'fileType'          => $notification['file_type'],
                'fileName'          => $notification['file_name'],
                'type'              => $notification['type'],
                'isRead'            => $notification['is_read'],
                'url'               => $url
            ];
        });

        $args['notifications'] = $notifications;

        return $args;
    }
}

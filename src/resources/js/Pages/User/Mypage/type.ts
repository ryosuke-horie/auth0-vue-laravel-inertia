import { NotificationListItemProps } from '@/Components/molecules/list/NotificationListItem/type';
import { FavoriteStaffListItemPorps } from '@/Components/molecules/list/FavoriteStaffListItem/type';

export type MypageProps = {
  /**
   * ユーザーID
   */
  userId: string;

  /**
   * ユーザー名
   */
  nickname: string;

  /**
   * お知らせリスト
   */
  notifications: NotificationListItemProps[];

  /**
   * プロフィール画像
   */
  userProfileImage: string;

  /**
   * お気に入りスタッフ
   */
  favoriteStaff: FavoriteStaffListItemPorps[];

  /**
   * ゲストユーザーかどうか
   */
  isGuestUser: isGuestUser;
};

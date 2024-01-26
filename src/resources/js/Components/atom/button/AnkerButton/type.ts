import { Method } from '@inertiajs/core';

export const AnkerButtonVariantProp = {
  Primary: 'primary',
  Secondary: 'secondary',
  Derk: 'derk',
  Success: 'success',
  Danger: 'danger',
  Warning: 'warning',
  Info: 'info',
  Light: 'light',
} as const;

export type AnkerButtonVariantProp = (typeof AnkerButtonVariantProp)[keyof typeof AnkerButtonVariantProp];

export type AnkerButtonProps = {
  /**
   * ボタンバリアント
   */
  variant?: AnkerButtonVariantProp;

  /**
   * アウトライン
   */
  isOutlined?: boolean;

  /**
   * ボタンテキスト
   */
  text: string;

  /**
   * ボタンアイコン
   */
  icon?: string;

  /**
   * URL
   */
  href: string;

  /**
   * メソッド
   */
  method?: Method;
};

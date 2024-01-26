import type { ButtonHTMLAttributes } from 'vue';

export const ButtonVariantProp = {
  Primary: 'primary',
  Secondary: 'secondary',
  Derk: 'derk',
  Success: 'success',
  Danger: 'danger',
  Warning: 'warning',
  Info: 'info',
  Light: 'light',
} as const;

export type ButtonVariantProp = (typeof ButtonVariantProp)[keyof typeof ButtonVariantProp];

export type ButtonProps = {
  /**
   * ボタンバリアント
   */
  variant?: ButtonVariantProp;

  /**
   * ボタンタイプ
   */
  type?: ButtonHTMLAttributes['type'];

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
   * ローディング判定
   */
  isLoading?: boolean;

  /**
   * ローディング中テキスト
   */
  loadingText?: string;

  /**
   * disabled
   */
  disabled?: boolean;
};

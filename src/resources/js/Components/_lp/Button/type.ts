export const ButtonVariantProp = {
  Blue: 'blue',
  Green: 'green',
  Orange: 'orange',
  Black: 'black',
  Red: 'red',
} as const;

export type ButtonVariantProp = (typeof ButtonVariantProp)[keyof typeof ButtonVariantProp];

export type ButtonProps = {
  /**
   * ボタンバリアント
   */
  variant?: ButtonVariantProp;

  /**
   * ボタンテキスト
   */
  text: string;

  /**
   * アイコン
   */
  icon?: string;

  /**
   * URL
   */
  href: string;
};

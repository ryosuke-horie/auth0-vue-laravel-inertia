export const ColorSectionVariantProp = {
  Gray: 'gray',
  White: 'white',
} as const;

export type ColorSectionVariantProp = (typeof ColorSectionVariantProp)[keyof typeof ColorSectionVariantProp];

export type ColorSectionProps = {
  variant?: ColorSectionVariantProp;
  isRounded?: boolean;
};

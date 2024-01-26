export const ModalVariantProp = {
  White: 'white',
  Black: 'black',
};

export type ModalVariantProp = (typeof ModalVariantProp)[keyof typeof ModalVariantProp];

export type ModalProps = {
  variant?: ModalVariantProp;
  headerText: string;
};

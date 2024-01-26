export const FormRequiredLabelTypeProp = {
  Required: 'required',
  Any: 'any',
} as const;

export type FormRequiredLabelTypeProp = (typeof FormRequiredLabelTypeProp)[keyof typeof FormRequiredLabelTypeProp];

export type FormRequiredLabelProps = {
  type: FormRequiredLabelTypeProp;
};

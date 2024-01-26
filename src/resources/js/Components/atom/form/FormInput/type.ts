export const FormInputTypeProp = {
  Text: 'text',
  Email: 'email',
  Password: 'password',
} as const;

export type FormInputTypeProp = (typeof FormInputTypeProp)[keyof typeof FormInputTypeProp];

export type FormInputProps = {
  id: string;
  type?: FormInputTypeProp;
  name?: string;
  modelValue: string | number;
  placeholder?: string;
  isError?: boolean;
  disabled?: boolean;
  minlength?: number;
  maxlength?: number;
};

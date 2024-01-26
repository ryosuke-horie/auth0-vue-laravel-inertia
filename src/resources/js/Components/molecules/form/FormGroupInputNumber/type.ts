import type { FormRequiredLabelTypeProp } from '@/Components/atom/form/FormRequiredLabel/type';

export type FormGroupInputNumberProps = {
  id: string;
  label?: string;
  requiredType?: FormRequiredLabelTypeProp;
  description?: string;
  annotation?: string;
  modelValue: number;
  placeholder?: string;
  error?: string;
  isCount?: boolean;
  countLimit?: number;
  countUnit?: string;
  min?: number;
  max?: number;
};

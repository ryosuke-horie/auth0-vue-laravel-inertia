import type { FormRequiredLabelTypeProp } from '@/Components/atom/form/FormRequiredLabel/type';

export type FormGroupTextareaProps = {
  id: string;
  label?: string;
  requiredType?: FormRequiredLabelTypeProp;
  description?: string;
  annotation?: string;
  modelValue: string;
  placeholder?: string;
  error?: string;
  isCount?: boolean;
  countLimit?: number;
  countUnit?: string;
};

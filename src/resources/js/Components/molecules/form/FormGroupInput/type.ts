import { FormInputTypeProp } from '@/Components/atom/form/FormInput/type';
import type { FormRequiredLabelTypeProp } from '@/Components/atom/form/FormRequiredLabel/type';

export type FormGroupInputProps = {
  id: string;
  type?: FormInputTypeProp;
  label?: string;
  requiredType?: FormRequiredLabelTypeProp;
  description?: string;
  annotation?: string;
  modelValue: string | number;
  placeholder?: string;
  error?: string;
  isCount?: boolean;
  countLimit?: number;
  countUnit?: string;
};

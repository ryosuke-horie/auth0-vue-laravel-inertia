export type FormSelectBoxOptionItem = {
  value: string | number;
  label: string;
  hidden?: boolean;
  disabled?: boolean;
};

export type FormSelectBoxProps = {
  id: string;
  name?: string;
  modelValue: string | number;
  placeholder?: string;
  isError?: boolean;
  disabled?: boolean;
  options: FormSelectBoxOptionItem[];
};

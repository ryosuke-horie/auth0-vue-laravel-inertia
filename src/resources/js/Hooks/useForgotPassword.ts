import { useForm } from '@inertiajs/vue3';

export const useForgotPassword = () => {
  const form = useForm({
    email: '',
  });

  const onSubmit = () => {
    form.post(route('staff.password.email'));
  };

  return {
    form,
    onSubmit,
  };
};

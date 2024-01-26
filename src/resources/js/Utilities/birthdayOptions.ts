export const yearOptions = () => {
  const currentYear = new Date().getFullYear();
  const hiddenOptions = [{ value: '', label: '----', hidden: true }];
  const options = [...Array(101)].map((_, i) => {
    return {
      value: String(currentYear - i),
      label: String(currentYear - i),
    };
  });

  return [...hiddenOptions, ...options];
};

export const monthOptions = () => {
  const hiddenOptions = [{ value: '', label: '--', hidden: true }];
  const options = [...Array(12)].map((_, i) => {
    return {
      value: String(i + 1),
      label: String(i + 1).padStart(2, '0'),
    };
  });
  return [...hiddenOptions, ...options];
};

export const dayOptions = (year: string, month: string) => {
  const hiddenOptions = [{ value: '', label: '--', hidden: true }];
  if (!year || !month) {
    const initOptions = [...Array(31)].map((_, i) => {
      return {
        value: String(i + 1),
        label: String(i + 1).padStart(2, '0'),
      };
    });
    return [...hiddenOptions, ...initOptions];
  }
  const parseYear = parseInt(year);
  const parseMonth = parseInt(month);
  const daysInMonth = new Date(parseYear, parseMonth, 0).getDate();
  const options = Array.from({ length: daysInMonth }, (_, i) => ({
    value: String(i + 1),
    label: String(i + 1).padStart(2, '0'),
  }));
  return [...hiddenOptions, ...options];
};

export const getDayOfWeek = (val: string): string => {
  switch (val) {
    case 'Monday':
      return '月';
    case 'Tuesday':
      return '火';
    case 'Wednesday':
      return '水';
    case 'Thursday':
      return '木';
    case 'Friday':
      return '金';
    case 'Saturday':
      return '土';
    case 'Sunday':
      return '日';
    default:
      return '';
  }
};

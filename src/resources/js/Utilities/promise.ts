export const wait = (msec: number) => {
  return new Promise((resolve) => {
    setTimeout(resolve, msec);
  });
};

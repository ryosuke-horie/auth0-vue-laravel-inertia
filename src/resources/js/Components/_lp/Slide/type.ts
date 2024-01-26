type SlideItem = {
  text: string;
  src: string;
};

export type SlideProps = {
  id: string;
  title: string;
  items: SlideItem[];
};

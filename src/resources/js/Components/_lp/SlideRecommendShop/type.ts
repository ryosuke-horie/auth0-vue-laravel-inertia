type SlideRecommendShopItemProps = {
  name: string;
  text: string;
  src: string;
};

export type SlideRecommendShopProps = {
  id: string;
  items: SlideRecommendShopItemProps[];
};

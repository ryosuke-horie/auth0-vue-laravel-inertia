type Snowflake = {
  x: number;
  y: number;
  vy: number;
  vx: number;
  r: number;
  o: number;
  color: string;
  reset: () => void;
};

const COUNT = 100;

let ctx: CanvasRenderingContext2D | null = null;
let width: number;
let height: number;
let active = false;
let snowflakes: Snowflake[] = [];

// 色の配列を定義
const colors = ['#ffc107', '#ff5722', '#4caf50', '#2196f3', '#9c27b0'];

export const initSnowflakeAnimation = (canvasElement: HTMLCanvasElement) => {
  canvasElement.width = 375; // キャンバスの幅を設定
  canvasElement.height = 600; // キャンバスの高さを設定

  ctx = canvasElement.getContext('2d');
  width = canvasElement.width;
  height = canvasElement.height;
  active = width > 200;

  const resetSnowflake = (snowflake: Snowflake) => {
    snowflake.x = Math.random() * width;
    snowflake.y = Math.random() * -height;
    snowflake.vy = 1 + Math.random() * 3;
    snowflake.vx = 0.5 - Math.random();
    snowflake.r = 1 + Math.random() * 3;
    snowflake.o = 0.5 + Math.random() * 0.5;
    snowflake.color = colors[Math.floor(Math.random() * colors.length)];
  };

  const update = () => {
    if (ctx) {
      ctx.clearRect(0, 0, width, height);

      if (!active) return;

      for (const snowflake of snowflakes) {
        snowflake.y += snowflake.vy;
        snowflake.x += snowflake.vx;

        ctx.globalAlpha = snowflake.o;
        ctx.beginPath();
        ctx.arc(snowflake.x, snowflake.y, snowflake.r, 0, Math.PI * 2, false);
        ctx.fillStyle = snowflake.color;
        ctx.fill();

        if (snowflake.y > height) {
          resetSnowflake(snowflake);
        }
      }

      requestAnimationFrame(update);
    }
  };

  if (active && ctx) {
    snowflakes = Array.from({ length: COUNT }, () => {
      const snowflake: Snowflake = {
        x: 0,
        y: 0,
        vy: 0,
        vx: 0,
        r: 0,
        o: 0,
        color: '',
        reset: () => resetSnowflake(snowflake),
      };
      resetSnowflake(snowflake);
      return snowflake;
    });
    requestAnimationFrame(update);
  }
};

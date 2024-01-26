/**
 * 画像データ取得
 * @param {Event} e
 * @returns {File | undefined}
 */
export const getFileImageData = (e: Event): File | undefined => {
  const target = e.target;
  if (!(target instanceof HTMLInputElement)) return;
  const file = target.files && target.files[0];
  if (!file) return;
  // ファイルサイズチェック
  if (file.size >= 10 * 1024 * 1024) {
    alert('ファイルサイズオーバー');
    return;
  }

  // ファイルタイプチェック
  if (!(file.type.match('image/png') || file.type.match('image/jpg') || file.type.match('image/jpeg'))) {
    alert('ファイルタイプエラー');
    return;
  }

  return file;
};

/**
 * 動画データ取得
 * @param {Event} e
 * @returns {File | undefined}
 */
export const getFileVideoData = (e: Event): File | undefined => {
  const target = e.target;
  if (!(target instanceof HTMLInputElement)) return;
  const file = target.files && target.files[0];
  if (!file) return;
  // ファイルサイズチェック
  if (file.size >= 20 * 1024 * 1024) {
    alert('ファイルサイズオーバー');
    return;
  }

  // ファイルタイプチェック
  if (!file.type.match('video/mp4')) {
    alert('ファイルタイプエラー');
    return;
  }

  // const element = document.createElement('video');
  // element.src = URL.createObjectURL(file);

  // element.onloadedmetadata = async () => {
  //   if (element.duration > 0) {
  //     alert('だめ');
  //   }
  // };

  // alert('aaa');

  return file;
};

/**
 * 画像・動画バイナリデータ取得
 */
export const getBinaryData = (file: File, callback: (binary: string) => void): void => {
  const fileReader = new FileReader();
  fileReader.readAsDataURL(file);
  fileReader.onload = (e: ProgressEvent<FileReader>) => {
    const target = e.target;
    if (!target) return;
    const result = e.target.result;
    if (typeof result !== 'string') return;
    if (e.target.readyState === FileReader.DONE) {
      callback(result);
    }
  };
};

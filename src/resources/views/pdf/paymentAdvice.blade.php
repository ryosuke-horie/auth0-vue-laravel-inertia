<!DOCTYPE html>
<html lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>支払通知書</title>
    <style>
        @font-face{
            font-family: ipag;
            font-style: normal;
            font-weight: normal;
            src:url('{{ storage_path("fonts/ipag.ttf")}}');
        }
        @page {
            size: A4; /* ページサイズの指定（A4など） */
            margin: 1cm 1.5cm; /* ページの余白を設定 */
        }
        body {
            width: 100%; /* HTML全体に幅を指定 */
            margin: 0;   /* マージンを0に設定 */
            font-family: ipag;
        }
        .title {
            text-align: center;
            font-size: 30px;
            text-decoration: underline;
            letter-spacing: 15px;
        }
        .right {
            text-align: right;
        }
        .left {
            text-align: left;
            padding-left: 15px;
        }
        .business-info {
            text-decoration: underline;
            line-height: 1;
            font-size: 15px;
        }
        .mits-info {
            width: 300px;
            float: right;
            font-size: 13px;
        }
        .mits-info > p {
            text-align: left; 
            line-height: 1;
        }
        .text {
            clear:both;
            padding-top: 40px;
            font-size: 13px;
        }
        table {
            border-collapse: collapse;
            margin: 20px auto 0;
            width: 100%;
            text-align: center;
            font-size: 13px;
            border: 2px solid #000;
        }
        th{
            border: 1px solid #000;
        }
        td {
            border: 1px solid #000;
            height: 20px;
        }
        .payment-amount {
            font-size: 20px;
            font-weight: bold;
        }
        .annotation {
            border: 2px solid;
            height: 100px;
            margin-top: -10px;
            font-size: 13px;
        }
        .red {
            color: red;
        }
        .back-color {
            background-color: rgb(209,255,255);
        }
        .none {
            border: none;
        }
    </style>
</head>
<body>
    <p class="right">{{ $targetDate }}</p>
    <p class="title">支払通知書</p>
    <p class="business-info">{{ $businessName }}&emsp;御中</p>
    <p class="business-info">貴社インボイス番号&emsp;T{{ $invoiceRegNum }}</p>
    <div class="mits-info">
        <p>マミヤITソリューションズ株式会社<br></p>
        <p>〒160-0023<br></p>
        <p>東京都新宿区西新宿6-18-1<br></p>
        <p>住友不動産新宿セントラルパークタワー24階<br></p>
        <p>TEL： 03-6284-2315 FAX：03-6284-2318<br></p>
        <p>【弊社インボイス番号&emsp;T1011101096520】</p>
    </div>
    <p class="text">今回のお支払は以下の通りとなりますので、&emsp;ご確認のほどよろしくお願い申し上げます。</p>
    <table>
        <tr>
            <td rowspan="4" class="back-color">お支払額<br>（税込）</td>
            <td rowspan="4" class="payment-amount">¥{{ $transferAmount }}</td>
            <td class="back-color">お支払予定日</td>
            <td>2023年12月9日</td>   
        </tr>
        <tr>
            <td rowspan="3" class="back-color">貴社指定口座</td>
            <td>{{ $confirmBankName }}</td>   
        </tr>
        <tr>
            <td>{{ $confirmBranchName }}</td>   
        </tr>
        <tr>
            <td>{{ $confirmAccountNumber }}</td>   
        </tr>
    </table>
    <table>
        <tr class="back-color">
            <td>項目（10％適用対象）</td>
            <td>取引年月日</td>
            <td>税率</td>
            <td>金額</td>
        </tr>
        <tr>
            <td class="left">投げ銭（全件）</td>
            <td>{{ $transactionPeriod }}</td>
            <td>非</td>
            <td class="right">¥{{ $transferRequestAmount }}</td>
        </tr>
        <tr>
            <td class="left">利用料（20%）</td>
            <td></td>
            <td>非</td>
            <td class="red right">¥-{{ $usageFee }}</td>
        </tr>
        <tr>
            <td class="left">決済手数料（3.6%）</td>
            <td></td>
            <td>非</td>
            <td class="red right">¥-{{ $paymentFee }}</td>
        </tr>
        <tr>
            <td class="left">振込手数料</td>
            <td>{{ $paymentDate }}</td>
            <td>10%</td>
            <td class="red right">¥-{{ $transferFeeAmount }}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="none"></td>
            <td colspan="2" class="red">税抜合計</td>
            <td class="red right">¥{{ $noTaxAmount }}</td>
        </tr>
        <tr>
            <td class="none"></td>
            <td colspan="2" class="red">消費税(10%)</td>
            <td class="red right">¥-{{ $tax }}</td>
        </tr>
        <tr>
            <td class="none"></td>
            <td colspan="2" class="red">合計金額</td>
            <td class="red right">¥{{ $transferAmount }}</td>
        </tr>
    </table>
    <p>備考</p>
    <p class="annotation">※送付後一定期間内に連絡がない場合は確認済みとさせていただきます。</p>
</body>
</html>
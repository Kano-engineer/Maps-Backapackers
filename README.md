![Maps Backapackers](https://user-images.githubusercontent.com/71540533/108969402-0cc7fd00-76c5-11eb-8510-728ae77c3730.gif)

![3:4](https://user-images.githubusercontent.com/71540533/109912799-20d8b380-7cf0-11eb-9c3b-864a0cf37bdf.gif)

# アプリ名：Maps.Backpackers(http://ec2-52-195-10-177.ap-northeast-1.compute.amazonaws.com/)

・ガイドブックに載っていないローカル情報を共有できる旅アプリです。

# 制作背景

・個人的に自転車一人旅が好きで、実際に旅をしながら既存のサービスでフォーカスされていない「この道が走りやすい」「地元の人しか知らない穴場で景色が綺麗」等のローカル情報を共有できるアプリケーションがあったら良いなと感じていました。そこで、旅好きな人達がローカル情報を共有でき、コロナ禍で移動が制限された中でもオンラインで旅を追体験できるSNS型アプリケーションを制作しようと考えました。

# 拘ったポイント

・開発はGit / Githubを用い、英語のコメントを付けながらプログラムを組み、現場での開発を意識して要件定義から簡単なテストまでを含めた作業を行いました。操作面においては「ユーザーがどうやったら使いやすいか」を考え、地図を用いる工夫をしました。詳細画面に遷移した際に、JavaScriptとGoogle APIによって地名/住所から緯度経度を取得し、自動で地図上にピンを表示させることができます。加えて、リアルタイムチャットにはVue.js、インフラにはAWSなど現場で使われているモダンな技術を取り入れる努力をしました。今後は地図機能の拡張、完全SPA化、CIツールやコンテナの導入、セキュリティ面の強化などを予定しています。最終的には対象とするユーザーをより具体化し、マネタイズするために必要な機能も含めて作り込み、一つの「サービス」として世に送り出したいと考えています。

# 使用言語

・PHP 7.3.11

    - Laravel 7.30.4

・JavaScript

    - Vue.js

# API 

・Pusher

・Google API ( Maps Javascript API / Geocoding API )


# インフラ / コード管理

・Git

・RDB

    - MySQL

・AWS

![aws-sample-1_ut1522819085](https://user-images.githubusercontent.com/71540533/109102044-579c5000-776b-11eb-9e0b-e3afb6f0e42e.png)

# 機能

・ゲストログイン機能

・管理ユーザー登録機能

・管理ユーザーログイン機能

・いいね機能

・フォロー機能

・記事投稿機能

・記事一覧表示機能

・記事詳細表示機能

・地図情報表示機能(地名/住所からピンを自動検索)

・画像アップロード機能

・コメント機能

・編集/削除機能

・リアルタイムチャット機能

・マネタイズするために必要な機能(実装中)

・レスポンシブデザイン(スマートフォン / タブレット)

# 使用手順
①トップ画面中央にあるオレンジの「GUEST LOGIN」ボタンで簡単にログインできます。

②ホーム画面上部の「地名/住所を入力して旅をシェアしよう」から自分が旅行に行った場所を投稿できます。

③「MAPを見る」で詳細ページに遷移し、写真投稿やコメントをすることができます。また、旅行に行った場所の編集も可能です。

④サイドバーの「My Profile」でプロフィール画面に遷移し、プロフィール画像や自己紹介文を設定できます。自分の投稿一覧やいいねした投稿の観覧もできます。

⑤サイドバーの「共有チャット/タイムライン」からリアルタイムチャットで交流できます。

⑥サイドバーの「MAPで検索」からMAPで投稿一覧を検索できます。＊実装中


# 今後の開発計画

・完全SPA化

・地図検索機能

・デザインとUI/UXの洗練

・S3 / RDS / Route53

・Jenkins連携で自動デプロイ

・Docker

・セキュリティ面の強化

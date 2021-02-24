![Maps Backapackers](https://user-images.githubusercontent.com/71540533/108969402-0cc7fd00-76c5-11eb-8510-728ae77c3730.gif)

# アプリ名：Maps.Backpackers(http://ec2-52-195-10-177.ap-northeast-1.compute.amazonaws.com/)

・ガイドブックに載っていないローカル情報を共有できる旅アプリです。

# 制作背景

・個人的に自転車一人旅が好きなので、旅好きな人達がガイドブックに載っていないローカル情報を共有でき、コロナ禍で移動が制限された中でもオンラインで旅を追体験できるSNS型アプリケーションを制作しました。

# 拘ったポイント

・開発はGit / Githubを用い、英語のコメントを付けながらプログラムを組み、チーム開発を意識して作業を行いました。操作面においては「ユーザーがどうやったら使いやすいか」を考え、地図を用いる工夫をしました。詳細画面に遷移した際に、JavaScriptとGoogle APIによって地名/住所から緯度経度を取得し、自動で地図上にピンを表示させることができます。加えて、リアルタイムチャットにはVue.js、インフラにはAWSなど現場で使われているモダンな技術を取り入れる努力をしました。今後は地図機能の拡張、完全SPA化、CIツールやコンテナの導入などを予定しています。

# 使用言語

・PHP 

    - Laravel

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

![image_from_ios](https://user-images.githubusercontent.com/71540533/109007760-da7fc500-76ef-11eb-812b-05edd7fc958a.jpg)

# 機能

・ゲストログイン

・管理ユーザ登録

・管理ユーザログイン

・いいね機能

・フォロー機能

・記事投稿

・記事一覧表示

・記事詳細表示

・地図情報表示(地名/住所からピンを自動検索)

・画像アップロード

・コメント機能

・編集/削除機能

・リアルタイムチャット機能

・レスポンシブデザイン(スマートフォン / タブレット)

# 今後の開発計画

・地図検索機能

・完全SPA化

・デザインとUI/UXの洗練

・S3 / RDS / Route53

・Jenkins連携で自動デプロイ

・Docker

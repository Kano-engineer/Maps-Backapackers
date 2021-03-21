![Maps Backpackers 3:20](https://user-images.githubusercontent.com/71540533/111856298-0f88db80-896d-11eb-8c01-e854f965e4c5.gif)

<p align="center">
  <a href="https://laravel.com"><img src="https://user-images.githubusercontent.com/71540533/111902059-cd4fbf00-8a7e-11eb-851b-f2ffff37f3f1.png" height="120px;" /></a>
  <a href="https://vuejs.org/index.html"><img src="https://user-images.githubusercontent.com/71540533/111902057-cc1e9200-8a7e-11eb-8878-38ecf9b89daf.png" height="120px;" /></a>
  <a href="https://console.cloud.google.com/apis/library?hl=ja&pli=1&project=maps-301303&folder=&organizationId=&rif_reserveds"><img src="https://user-images.githubusercontent.com/71540533/111902297-37b52f00-8a80-11eb-88ec-b3c7d98ab01e.png" height="120px;" /></a>
  <a href="https://git-scm.com/"><img src="https://user-images.githubusercontent.com/71540533/111902546-5831b900-8a81-11eb-8bc5-648841923e35.png" height="120px;" /></a>
  <a href="https://www.mysql.com/"><img src="https://user-images.githubusercontent.com/71540533/111902721-20774100-8a82-11eb-9183-8c8c38012c75.png" height="120px;" /></a>
  <a href="https://aws.amazon.com/?nc1=h_ls"><img src="https://user-images.githubusercontent.com/71540533/111902063-cde85580-8a7e-11eb-8b8c-6b1f7e02c2e3.jpg" height="120px;" /></a>
</p>

# アプリ名：Maps.Backpackers

# URL：http://ec2-52-195-10-177.ap-northeast-1.compute.amazonaws.com/

# 概要

・ガイドブックに載っていないローカル情報を共有できる旅アプリです。

# 制作背景

・自転車一人旅が好きで、既存のサービスでフォーカスされていないローカル情報を共有できるアプリケーションがあったら便利だと感じていたので作成しました。

# 拘ったポイント

・「サービス」として作り込む意識を持って制作しています。

①対象ユーザーの具体化

②マネタイズするための機能


# 使用言語

・PHP 7.3.11

    - Laravel 7.30.4

・JavaScript

    - Vue.js 7.6.3

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

・レスポンシブデザイン(スマートフォン / タブレット)

# 使用手順
①トップ画面中央にあるオレンジの「GUEST LOGIN」ボタンで簡単にログインできます。

②ホーム画面上部の「地名/住所を入力して旅をシェアしよう」から自分が旅行に行った場所を投稿できます。

③「MAPを見る」で詳細ページに遷移し、写真投稿やコメントをすることができます。また、旅行に行った場所の編集も可能です。

④サイドバーの「My Profile」でプロフィール画面に遷移し、プロフィール画像や自己紹介文を設定できます。自分の投稿一覧やいいねした投稿の観覧もできます。

⑤サイドバーの「共有チャット/タイムライン」からリアルタイムチャットで交流できます。

⑥サイドバーの「MAPで検索」からMAPで投稿一覧を検索できます。＊実装中

# ローカル環境へのインストール方法

    $ git clone https://github.com/Kano-engineer/Maps-Backapackers
    $ cd Maps-Backapackers
    $ composer install
    $ cp .env.example .env
    $ php artisan migrate
    $ php artisan key:generate

# 今後の開発計画

・マネタイズするために必要な機能

・完全SPA化

・地図検索機能

・UI/UXの洗練

・S3 / RDS / Route53

・Jenkins連携で自動デプロイ

・Docker

・セキュリティの強化

cf.Issues：https://github.com/Kano-engineer/Maps-Backapackers/issues

# 製作者

・Twitter：https://twitter.com/kano_engineer

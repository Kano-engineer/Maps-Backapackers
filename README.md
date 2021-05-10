![4:6 After Brushup](https://user-images.githubusercontent.com/71540533/113684853-975a3e00-9700-11eb-8162-a446781bed5d.gif)


<p align="center">
  <a href="https://laravel.com"><img src="https://user-images.githubusercontent.com/71540533/111902059-cd4fbf00-8a7e-11eb-851b-f2ffff37f3f1.png" height="100px;" /></a>
<!--   <a href="https://vuejs.org/index.html"><img src="https://user-images.githubusercontent.com/71540533/111902057-cc1e9200-8a7e-11eb-8878-38ecf9b89daf.png" height="100px;" /></a> -->
  <a href="https://console.cloud.google.com/apis/library?hl=ja&pli=1&project=maps-301303&folder=&organizationId=&rif_reserveds"><img src="https://user-images.githubusercontent.com/71540533/111902297-37b52f00-8a80-11eb-88ec-b3c7d98ab01e.png" height="100px;" /></a>
  <a href="https://tinypng.com/developers"><img src="https://user-images.githubusercontent.com/71540533/115167113-34e64200-a0f1-11eb-8be9-6081ac728b78.png" height="100px;" /></a>
  <a href="https://pusher.com/channels?campaignid=916184871&utm_source=adwords&utm_medium=cpc&utm_campaign=Brand_Pusher_Exact&utm_term=pusher%20api&utm_creative=264982473776&gclid=Cj0KCQjw3duCBhCAARIsAJeFyPVYHAebhDkuoH2xAOXBdB1fHou4JHfQ40-PsQGTVIo-Mi_2fYLcGcAaAnIJEALw_wcB"><img src="https://user-images.githubusercontent.com/71540533/111903081-d1321000-8a83-11eb-9406-97ff49477d6a.png" height="100px;" /></a>
  <a href="https://git-scm.com/"><img src="https://user-images.githubusercontent.com/71540533/111902546-5831b900-8a81-11eb-8bc5-648841923e35.png" height="100px;" /></a>
  <a href="https://www.mysql.com/"><img src="https://user-images.githubusercontent.com/71540533/111902721-20774100-8a82-11eb-9183-8c8c38012c75.png" height="100px;" /></a>
  <a href="https://aws.amazon.com/?nc1=h_ls"><img src="https://user-images.githubusercontent.com/71540533/111902063-cde85580-8a7e-11eb-8b8c-6b1f7e02c2e3.jpg" height="100px;" /></a>
</p>

# アプリ名：Maps.Backpackers

# URL：http://ec2-52-195-10-177.ap-northeast-1.compute.amazonaws.com/

# 概要

・ローカル情報を共有できるSNS型の旅アプリケーションです。

# 制作背景

・自転車一人旅が好きで、既存のサービスやガイドブックでフォーカスされていないローカル情報を共有できるアプリケーションがあったら便利だと感じていたので作成しました。

# 拘ったポイント

・Google Maps APIを使用して、感覚的な操作を実装しました。

・TinyPNG APIを使用して、投稿画像の最適化を行いました。

# 使用言語

・PHP 7.3.11

    - Laravel 7.30.4

・JavaScript

# API 

・Google API ( Maps Javascript API / Geocoding API )

・TinyPNG API

# インフラ / コード管理

・Git

・RDB

    - MySQL

・AWS

    - EC2
    
    - S3
    
    - RDS
![aws-sample-1_ut1522819085](https://user-images.githubusercontent.com/71540533/109102044-579c5000-776b-11eb-9e0b-e3afb6f0e42e.png)

# 機能

○トップ画面

・ゲストログイン機能

・管理ユーザー登録機能

・管理ユーザーログイン機能

○ホーム画面

・記事投稿機能

・画像プレビュー機能

・画像アップロード機能

・APIを用いた画像ロスレス圧縮機能

・地図情報投稿機能

・地図投稿一覧表示機能

・記事一覧表示機能

・いいね機能

・記事詳細表示機能 

・タブメニュー：タイムライン / いいねした投稿一覧画面切り替え機能

○詳細画面

・地図情報表示機能 

・コメント機能

・編集/削除機能

・認可機能(Policy)

○プロフィール

・プロフィール画像設定機能

・フォロー機能

・タブメニュー：ユーザーの投稿一覧 / いいねした投稿一覧画面切り替え機能

○サイドバー

・検索機能

○UI/UX

・レスポンシブデザイン(スマートフォン / タブレット)

# 使用手順
①トップ画面中央にあるオレンジの「GUEST LOGIN」ボタンで簡単にログインできます。

②ホーム画面上部の「Share Your Travel!」から自分が旅行に行った場所と文章、写真を投稿できます。

③ホーム画面では地図とタイムラインで投稿一覧を観覧でき、いいねすることも出来ます。投稿をクリックすると詳細ページに遷移し、写真投稿やコメントをすることができます。また、詳細ページ下部のEDITで旅行に行った場所の編集も可能です。

④サイドバーのアバター画像と上部の「My Profile」からプロフィール画面に遷移し、プロフィール画像や自己紹介文を設定できます。ユーザーの投稿一覧やいいねした投稿の観覧もできます。

⑤検索機能から地図 / タイムライン / ユーザーを検索できます。

# ローカル環境へのインストール方法

    $ git clone https://github.com/Kano-engineer/Maps-Backapackers
    $ cd Maps-Backapackers
    $ composer install
    $ cp .env.example .env
    $ php artisan migrate
    $ php artisan key:generate

# 今後の開発計画

・適宜フィードバックを取り入れながら改善

・UI/UXの洗練

・投稿フォームのUI改善

・いいね / フォロー機能の非同期化

・Repositoryパターンによる実装

・投稿フォームのUI改善

・セキュリティの強化

・マネタイズするために必要な機能

・完全SPA化

・Docker

・Circle CI

cf.Issues：https://github.com/Kano-engineer/Maps-Backapackers/issues

# 製作者

・Twitter：https://twitter.com/kano_engineer

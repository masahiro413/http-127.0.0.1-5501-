# Portfolio WordPress Theme

PHP WordPress ポートフォリオサイトテーマ

## 概要

このリポジトリは、PHP / WordPress を使用したポートフォリオサイト用カスタムテーマです。  
作品・実績を美しく展示するための機能を備えています。

## 特徴

- **カスタム投稿タイプ**: `portfolio` — 作品ページを専用管理
- **カスタムタクソノミー**: `portfolio_category`（カテゴリー）・`portfolio_skill`（スキル・技術）
- **カスタムメタボックス**: クライアント名・プロジェクトURL・制作年月・担当役割
- **レスポンシブデザイン**: PC・タブレット・スマートフォン対応
- **フロントページ**: ヒーローセクション・実績数・ポートフォリオ一覧・自己紹介・お問い合わせフォーム
- **カテゴリーフィルター**: クライアントサイドでの作品絞り込み
- **WordPress カスタマイザー対応**: ヒーローテキスト・スキル一覧・SNSリンクをダッシュボードから編集可能
- **アクセシビリティ対応**: セマンティックHTML・aria属性・キーボードナビゲーション

## ディレクトリ構成

```
wp-content/themes/portfolio/
├── style.css                   # テーマヘッダー & CSS
├── functions.php               # テーマ設定・CPT・タクソノミー登録
├── index.php                   # メインテンプレート
├── front-page.php              # フロントページ
├── header.php                  # ヘッダー
├── footer.php                  # フッター
├── page.php                    # 固定ページ
├── archive-portfolio.php       # ポートフォリオ一覧
├── single-portfolio.php        # ポートフォリオ詳細
├── template-parts/
│   └── portfolio-card.php      # ポートフォリオカード
└── assets/
    └── js/
        └── main.js             # JavaScript (メニュー・フィルター・スムーススクロール)
```

## インストール方法

1. このリポジトリをクローンまたは ZIP でダウンロードします。
2. `wp-content/themes/portfolio/` ディレクトリを WordPress の `wp-content/themes/` に配置します。
3. WordPress 管理画面 → **外観 → テーマ** から「Portfolio」を有効化します。
4. **外観 → メニュー** でナビゲーションメニューを設定します。
5. **ポートフォリオ** メニューから作品を追加します。
6. **外観 → カスタマイズ** でサイト名・ヒーローテキスト・スキル・SNSリンクを設定します。

## 推奨プラグイン

- [Contact Form 7](https://wordpress.org/plugins/contact-form-7/) — お問い合わせフォーム
- [Yoast SEO](https://wordpress.org/plugins/wordpress-seo/) — SEO設定

## ライセンス

GNU General Public License v2 or later  
https://www.gnu.org/licenses/gpl-2.0.html

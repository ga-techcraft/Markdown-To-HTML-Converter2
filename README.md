## 概要

このプロジェクトは、ブラウザ上で **Markdown を HTML に変換できる Web アプリケーション** です。  
Monaco Editor を使用したリッチなエディタを備え、変換結果をプレビューできるほか、  変換後の HTML をファイルとしてダウンロードする機能を提供します。

---

## 目次
- [機能](#機能)
- [セットアップ手順](#セットアップ手順)
  - [1. 必要な環境](#1-必要な環境)
  - [2. プロジェクトのクローン](#2-プロジェクトのクローン)
  - [3. Python の仮想環境（venv）を作成し、`markdown` をインストール](#3-python-の仮想環境venvを作成しmarkdown-をインストール)
  - [4. Web サーバーを起動](#4-web-サーバーを起動)
  - [5. ブラウザでアクセス](#5-ブラウザでアクセス)
- [使用方法](#使用方法)
- [カスタマイズ](#カスタマイズ)

---

## **機能**
- ブラウザ上で Markdown を入力できる Monaco Editor を搭載
- Markdown をリアルタイムで HTML に変換し、プレビューを表示
- 変換後の HTML を **ファイルとしてダウンロード可能**
- **Bootstrap** による洗練された UI デザイン
- **Python** (`markdown` ライブラリ) を使用してサーバー側で変換処理を実行

---

## **セットアップ手順**

### **1. 必要な環境**
- **Web サーバー（Apache または Nginx）**
- **PHP 7.4+**
- **Python 3**
- **pip（Python パッケージ管理ツール）**
- **Composer（PHPパッケージ管理ツール）**

### **2. プロジェクトのクローン**
```bash
git clone https://github.com/yourusername/markdown-to-html.git
cd markdown-to-html
```

### **3. Python の仮想環境（venv）を作成し、`markdown` をインストール**
```bash
python3 -m venv venv
source venv/bin/activate  # Windowsの場合: venv\Scripts\activate
pip install markdown
```

### **4. Web サーバーを起動**
#### **Apache（ローカル環境）**
```bash
php -S localhost:8000
```
#### **Nginx（EC2 環境など）**
- `nginx.conf` に `convert.php` を設定
- PHP-FPM をインストールして有効化

### **5. ブラウザでアクセス**
http://localhost:8000/


---

## **使用方法**
### **1. Markdown を入力**
- `# Markdown` などを **エディタ** に入力

### **2. 「変換」ボタンをクリック**
- **プレビューエリア** に HTML が即時表示されます

### **3. 「HTMLとしてダウンロード」ボタンをクリック**
- 変換された HTML を `.html` ファイルとしてダウンロード

---

## **カスタマイズ**
### **エディタのテーマを変更**
`index.html` 内の Monaco Editor の設定を変更
```js
editor = monaco.editor.create(document.getElementById('editor-container'), {
    value: '',
    language: 'markdown',
    theme: 'vs-dark' // → 'vs-light' でライトテーマに
});
```
---


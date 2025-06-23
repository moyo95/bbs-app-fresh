import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


// resources/js/app.js

// import './bootstrap';

// import Alpine from 'alpinejs';

// window.Alpine = Alpine;

// Alpine.start();


// // DOMが完全に読み込まれたら、いいね機能の初期化を実行
// document.addEventListener('DOMContentLoaded', function() {
//     // ページ内にいいねボタンがある場合のみ、処理を実行
//     if (document.getElementById('likeButton')) {
//         initializeLikeFeature();
//     }
// });

// /**
//  * いいね機能の初期化とイベントリスナーの設定を行う関数
//  */
// function initializeLikeFeature() {
//     // --- 必要な要素を全て取得 ---
//     const likeButton = document.getElementById('likeButton');
//     const animationElement = document.getElementById('heart-sprite-animation');
//     const likeCountElement = document.getElementById('likeCount');
//     const iconLiked = document.getElementById('icon-liked');
//     const iconUnliked = document.getElementById('icon-unliked');
//     const isLoggedIn = document.body.dataset.isLoggedIn === 'true';

//     // HTMLのdata属性からCSSクラスの配列を取得
//     const likedClasses = JSON.parse(likeButton.dataset.likedClasses || '[]');
//     const unlikedClasses = JSON.parse(likeButton.dataset.unlikedClasses || '[]');

//     // アニメーション終了時の後片付け
//     if (animationElement) {
//         animationElement.addEventListener('animationend', () => {
//             animationElement.classList.remove('is-playing');
//         });
//     }

//     // --- クリックイベントの処理 ---
//     likeButton.addEventListener('click', function() {
//         // ログインチェック
//         if (!isLoggedIn) {
//             alert('いいねをするには、ログインまたは新規登録が必要です。');
//             return; 
//         }

//         // 連打防止のためにボタンを一時的に無効化
//         this.disabled = true;

//         const postId = this.dataset.postId;
//         const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

//         // サーバーに通信
//         fetch(`/posts/${postId}/like`, {
//             method: 'POST',
//             headers: {
//                 'X-CSRF-TOKEN': csrfToken,
//                 'Content-Type': 'application/json',
//                 'Accept': 'application/json'
//             },
//         })
//         .then(response => {
//             if (!response.ok) {
//                 // 通信自体が失敗した場合（サーバーエラーなど）
//                 return Promise.reject(new Error(`Server responded with ${response.status}`));
//             }
//             return response.json();
//         })
//         .then(data => {
//             // ★★★ サーバーからの正しいデータに基づいてUIを完全に更新 ★★★
            
//             // 1. いいね数を更新
//             if (likeCountElement && data.likeCount !== undefined) {
//                 likeCountElement.innerHTML = `<span class="font-bold">${data.likeCount}</span>件のいいね`;
//             }

//             // 2. サーバーからの "isLiked" の状態に応じてアイコンとボタンスタイルを更新
//             if (data.isLiked) {
//                 // "いいね" された時の処理
//                 iconLiked.classList.remove('hidden');
//                 unlikedIcon.classList.add('hidden');
//                 this.classList.remove(...unlikedClasses);
//                 this.classList.add(...likedClasses);

//                 // アニメーションを実行
//                 if (animationElement) {
//                     animationElement.classList.remove('is-playing'); // 念のためリセット
//                     void this.offsetWidth; // 強制リフロー
//                     animationElement.classList.add('is-playing');
//                 }
//             } else {
//                 // "いいね解除" された時の処理
//                 iconLiked.classList.add('hidden');
//                 unlikedIcon.classList.remove('hidden');
//                 this.classList.remove(...likedClasses);
//                 this.classList.add(...unlikedClasses);
//             }
//         })
//         .catch(error => {
//             console.error('いいねの処理でエラーが発生しました:', error);
//             // ここでUIを元に戻す処理を入れることも可能だが、一旦シンプルにする
//         })
//         .finally(() => {
//             // 処理が成功しても失敗しても、ボタンを再度有効化する
//             this.disabled = false;
//         });
//     });
// }
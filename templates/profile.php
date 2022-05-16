<main class="page__main page__main--profile">
      <h1 class="visually-hidden">Профиль</h1>
      <div class="profile profile--default">
        <div class="profile__user-wrapper">
          <div class="profile__user user container">
            <div class="profile__user-info user__info">
              <div class="profile__avatar user__avatar">
                <?php if (!empty($profile['avatar'])):?>
                   <img class="profile__picture user__picture" src="uploads/<?=strip_tags($profile['avatar']);?>" alt="Аватар пользователя">
                <?php endif; ?>
              </div>
              <div class="profile__name-wrapper user__name-wrapper">
                <span class="profile__name user__name"><?=htmlspecialchars($profile['login']);?></span>
                <time class="profile__user-time user__time" datetime="<?=strip_tags($profile['date']);?>"><?=convert_date_relative_format($profile['date'])?> на сайте</time>
              </div>
            </div>
            <div class="profile__rating user__rating">
              <p class="profile__rating-item user__rating-item user__rating-item--publications">
                <span class="user__rating-amount"><?=strip_tags($profile['posts']);?></span>
                <span class="profile__rating-text user__rating-text">публикаций</span>
              </p>
              <p class="profile__rating-item user__rating-item user__rating-item--subscribers">
                <span class="user__rating-amount"><?=strip_tags($profile['subscribed']);?></span>
                <span class="profile__rating-text user__rating-text">подписчиков</span>
              </p>
            </div>
            <div class="profile__user-buttons user__buttons">
            <?php if ($profile['id'] !== $_SESSION['user_id']):?>
              <a class="profile__user-button user__button user__button--subscription button button--<?=($subscr_profile === false) ? 'main' : 'quartz';?>" href="subscription.php?user_id=<?=strip_tags($profile['id']);?>"><?=($subscr_profile === false) ? 'Подписаться' : 'Отписаться';?></a>
                <?php if ($subscr_profile !== false): ?><a class="profile__user-button user__button user__button--writing button button--green" href="messages.php?user_id=<?=$profile['id'];?>">Сообщение</a><?php endif;?>
            <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="profile__tabs-wrapper tabs">
          <div class="container">
            <div class="profile__tabs filters">
              <b class="profile__tabs-caption filters__caption">Показать:</b>
              <ul class="profile__tabs-list filters__list tabs__list">
                <li class="profile__tabs-item filters__item">
                  <a class="profile__tabs-link filters__button tabs__item button <?php if ($show === 'posts'):?>filters__button--active tabs__item--active<?php endif;?>" href="profile.php?user_id=<?=strip_tags($profile['id']);?>&show=posts">Посты</a>
                </li>
                <li class="profile__tabs-item filters__item">
                  <a class="profile__tabs-link filters__button tabs__item button <?php if ($show === 'likes'):?>filters__button--active tabs__item--active<?php endif;?>" href="profile.php?user_id=<?=strip_tags($profile['id']);?>&show=likes">Лайки</a>
                </li>
                <li class="profile__tabs-item filters__item">
                  <a class="profile__tabs-link filters__button tabs__item button <?php if ($show === 'subscriptions'):?>filters__button--active tabs__item--active<?php endif;?>" href="profile.php?user_id=<?=strip_tags($profile['id']);?>&show=subscriptions">Подписки</a>
                </li>
              </ul>
            </div>
            <div class="profile__tab-content">
              <?=$content;?>
            </div>
          </div>
        </div>
      </div>
    </main>

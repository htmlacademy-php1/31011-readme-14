<main class="page__main page__main--publication">
  <div class="container">
    <h1 class="page__title page__title--publication"><?=htmlspecialchars($post['header']);?></h1>
    <section class="post-details">
      <h2 class="visually-hidden">Публикация</h2>
      <div class="post-details__wrapper post-photo">
        <div class="post-details__main-block post post--details">
          <?=$content;?>
          <div class="post__indicators">
            <div class="post__buttons">
              <a class="post__indicator post__indicator--likes button" href="likes.php?id=<?=strip_tags($post['id']);?>" title="Лайк">
                <svg class="post__indicator-icon" width="20" height="17">
                  <use xlink:href="#icon-heart"></use>
                </svg>
                <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                  <use xlink:href="#icon-heart-active"></use>
                </svg>
                <span><?=strip_tags($post['likes_count']);?></span>
                <span class="visually-hidden">количество лайков</span>
              </a>
              <a class="post__indicator post__indicator--comments button" href="#comments" title="Комментарии">
                <svg class="post__indicator-icon" width="19" height="17">
                  <use xlink:href="#icon-comment"></use>
                </svg>
                <span><?=strip_tags($post['comments_count']);?></span>
                <span class="visually-hidden">количество комментариев</span>
              </a>
              <a class="post__indicator post__indicator--repost button" href="#" title="Репост">
                <svg class="post__indicator-icon" width="19" height="17">
                  <use xlink:href="#icon-repost"></use>
                </svg>
                <span>5</span>
                <span class="visually-hidden">количество репостов</span>
              </a>
            </div>
            <span class="post__view"><?=strip_tags($post['view']);?> просмотров</span>
          </div>
          <ul class="post__tags">
            <?php foreach ($tags as $tag):?>
                <li><a href="search.php?search=%23<?=strip_tags($tag['hashtag']);?>">#<?=strip_tags($tag['hashtag']);?></a></li>
            <?php endforeach;?>
          </ul>
          <div class="comments">
            <form class="comments__form form" action="post.php?id=<?=strip_tags($post['id']);?>" method="post">
              <input type="hidden" name="post_id" value="<?=strip_tags($post['id']);?>">
              <div class="comments__my-avatar">
                <img class="comments__picture" src="<?php if (!empty($_SESSION['avatar'])):?>uploads/<?=strip_tags($_SESSION['avatar']);?><?php endif; ?>" alt="Аватар пользователя">
              </div>
              <div class="form__input-section <?php if(!empty($errors['comment'])):?>form__input-section--error<?php endif;?>">
                <textarea class="comments__textarea form__textarea form__input" name="comment" placeholder="Ваш комментарий"><?=htmlspecialchars($data_comment);?></textarea>
                <label class="visually-hidden">Ваш комментарий</label>
                <button class="form__error-button button" type="button">!</button>
                <div class="form__error-text">
                  <h3 class="form__error-title"><?= (!empty($errors['comment']['header'])) ? $errors['comment']['header'] : ''; ?></h3>
                  <p class="form__error-desc"><?= (!empty($errors['comment']['text'])) ? $errors['comment']['text'] : ''; ?></p>
                </div>
              </div>
              <button class="comments__submit button button--green" type="submit">Отправить</button>
            </form>
            <div id="comments" class="comments__list-wrapper">
              <ul class="comments__list">
                <?php foreach($post_comments as $comment):?>
                <li class="comments__item user">
                  <div class="comments__avatar">
                    <a class="user__avatar-link" href="profile.php?user_id=<?=strip_tags($comment['user_id']);?>">
                      <img class="comments__picture" src="<?php if (!empty($comment['avatar'])):?>uploads/<?=strip_tags($comment['avatar']);?><?php endif; ?>" alt="Аватар пользователя">
                    </a>
                  </div>
                  <div class="comments__info">
                    <div class="comments__name-wrapper">
                      <a class="comments__user-name" href="profile.php?user_id=<?=strip_tags($comment['user_id']);?>">
                        <span><?=$comment['login']?></span>
                      </a>
                      <time class="comments__time" datetime="<?=strip_tags($comment['date']);?>"><?=convert_date_relative_format($comment['date'])?> назад</time>
                    </div>
                    <p class="comments__text">
                        <?=$comment['post']?>
                    </p>
                  </div>
                </li>
                <?php endforeach;?>
              </ul>
              <?php if (count($post_comments) > 10):?>
              <a class="comments__more-link" href="#">
                <span>Показать все комментарии</span>
                <sup class="comments__amount"><?=count($post_comments);?></sup>
              </a>
              <?php endif;?>
            </div>
          </div>
        </div>
        <div class="post-details__user user">
          <div class="post-details__user-info user__info">
            <?php if ($post['avatar']):?>
            <div class="post-details__avatar user__avatar">
              <a class="post-details__avatar-link user__avatar-link" href="profile.php?user_id=<?=$post['user_id']?>">
                <img class="post-details__picture user__picture" src="<?php if (!empty($post['avatar'])):?>uploads/<?=$post['avatar'];?><?php endif; ?>" alt="Аватар пользователя">
              </a>
            </div>
            <?php endif;?>
            <div class="post-details__name-wrapper user__name-wrapper">
              <a class="post-details__name user__name" href="profile.php?user_id=<?=$post['user_id'];?>">
                <span><?=$post['login']?></span>
              </a>
              <time class="post-details__time user__time" datetime="<?=strip_tags($post['reg_date']);?>"><?=convert_date_relative_format($post['reg_date'])?> на сайте</time>
            </div>
          </div>
          <div class="post-details__rating user__rating">
            <p class="post-details__rating-item user__rating-item user__rating-item--subscribers">
              <span class="post-details__rating-amount user__rating-amount"><?=$post['subscribed']?></span>
              <span class="post-details__rating-text user__rating-text">подписчиков</span>
            </p>
            <p class="post-details__rating-item user__rating-item user__rating-item--publications">
              <span class="post-details__rating-amount user__rating-amount"><?=$post['posts']?></span>
              <span class="post-details__rating-text user__rating-text">публикаций</span>
            </p>
          </div>
          <div class="post-details__user-buttons user__buttons">
            <?php if ($_SESSION['user_id'] !== $post['user_id']): ?>
                <a class="user__button user__button--subscription button button--<?=($post['me_subscribed'] == 0) ? 'main' : 'quartz';?>" href="subscription.php?user_id=<?=$post['user_id']?>"><?=($post['me_subscribed'] == 0) ? 'Подписаться' : 'Отписаться';?></a>
                <?php if ($post['me_subscribed'] != 0): ?>
                    <a class="user__button user__button--writing button button--green" href="messages.php">Сообщение</a>
                <?php endif;?>
            <?php endif;?>
          </div>
        </div>
      </div>
    </section>
  </div>
</main>

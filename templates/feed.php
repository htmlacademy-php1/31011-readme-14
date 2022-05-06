<main class="page__main page__main--feed">
      <div class="container">
        <h1 class="page__title page__title--feed">Моя лента</h1>
      </div>
      <div class="page__main-wrapper container">
        <section class="feed">
          <h2 class="visually-hidden">Лента</h2>
          <div class="feed__main-wrapper">
            <div class="feed__wrapper">
            <?php foreach ($posts as $post):?>
              <article class="feed__post post post-<?=strip_tags($post['type']);?>">
                <header class="post__header post__author">
                  <a class="post__author-link" href="profile.php?user_id=<?=strip_tags($post['user_id']);?>" title="Автор">
                    <div class="post__avatar-wrapper">
                      <img class="post__author-avatar" src="uploads/<?=strip_tags($post['avatar']);?>" alt="Аватар пользователя" width="60" height="60">
                    </div>
                    <div class="post__info">
                      <b class="post__author-name"><?=htmlspecialchars($post['login']);?></b>
                      <span class="post__time" datetime="<?=strip_tags($post['date']);?>"><?=convert_date_relative_format($post['date'])?> назад</span>
                    </div>
                  </a>
                </header>
                <div class="post__main">
                  <h2><a href="post.php?id=<?=$post['id'];?>"><?=htmlspecialchars($post['header']);?></a></h2>
                  <?php if ($post['type'] === 'text'):?>
                    <?=cropping_post($post['id'], htmlspecialchars($post['post']));?>
                  <?php elseif ($post['type'] === 'quote'):?>
                    <blockquote>
                    <p>
                        <?=htmlspecialchars($post['post']);?>
                    </p>
                    <cite><?=htmlspecialchars($post['author_quote']);?></cite>
                    </blockquote>
                  <?php elseif ($post['type'] === 'photo'):?>
                    <div class="post-photo__image-wrapper">
                        <img src="uploads/<?=strip_tags($post['image_link']);?>" alt="Фото от пользователя" width="760" height="396">
                    </div>
                  <?php elseif ($post['type'] === 'video'):?>
                    <div class="post-video__block">
                        <div class="post-video__preview">
                            <?=embed_youtube_cover(strip_tags($post['video_link'])); ?>
                            <img src="img/coast.jpg" alt="Превью к видео" width="760" height="396">
                        </div>
                        <div class="post-video__control">
                            <button class="post-video__play post-video__play--paused button button--video" type="button"><span class="visually-hidden">Запустить видео</span></button>
                            <div class="post-video__scale-wrapper">
                                <div class="post-video__scale">
                                    <div class="post-video__bar">
                                        <div class="post-video__toggle"></div>
                                    </div>
                                </div>
                            </div>
                            <button class="post-video__fullscreen post-video__fullscreen--inactive button button--video" type="button"><span class="visually-hidden">Полноэкранный режим</span></button>
                        </div>
                        <button class="post-video__play-big button" type="button">
                            <svg class="post-video__play-big-icon" width="27" height="28">
                                <use xlink:href="#icon-video-play-big"></use>
                            </svg>
                            <span class="visually-hidden">Запустить проигрыватель</span>
                        </button>
                        </div>
                  <?php elseif ($post['type'] === 'link'):?>
                    <div class="post-link__wrapper">
                        <a class="post-link__external" href="<?=strip_tags($post['site_link']);?>" title="Перейти по ссылке">
                            <div class="post-link__icon-wrapper">
                                <img src="img/logo-vita.jpg" alt="Иконка">
                            </div>
                            <div class="post-link__info">
                                <h3><?=htmlspecialchars($post['header']);?></h3>
                                <span><?=htmlspecialchars($post['post']);?></span>
                            </div>
                            <svg class="post-link__arrow" width="11" height="16">
                                <use xlink:href="#icon-arrow-right-ad"></use>
                            </svg>
                        </a>
                    </div>
                  <?php endif;?>
                </div>
                <footer class="post__footer post__indicators">
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
                    <a class="post__indicator post__indicator--comments button" href="post.php?id=<?=strip_tags($post['id'])?>#comments" title="Комментарии">
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
                </footer>
              </article>
            <?php endforeach;?>
            </div>
          </div>
          <ul class="feed__filters filters">
            <li class="feed__filters-item filters__item">
              <a class="filters__button <?php if (!$ctype): ?>filters__button--active<?php endif;?>" href="feed.php">
                <span>Все</span>
              </a>
            </li>
            <?php foreach($content_types as $type): ?>
            <li class="feed__filters-item filters__item">
              <a class="filters__button filters__button--<?=strip_tags($type['type']);?> button <?php if ($ctype == $type['id']):?>filters__button--active<?php endif;?>" href="?ctype=<?=strip_tags($type['id']);?>">
                <span class="visually-hidden"><?=strip_tags($type['name']);?></span>
                <svg class="filters__icon" width="22" height="18">
                  <use xlink:href="#icon-filter-<?=strip_tags($type['type']);;?>"></use>
                </svg>
              </a>
            </li>
            <?php endforeach;?>
          </ul>
        </section>
        <aside class="promo">
          <article class="promo__block promo__block--barbershop">
            <h2 class="visually-hidden">Рекламный блок</h2>
            <p class="promo__text">
              Все еще сидишь на окладе в офисе? Открой свой барбершоп по нашей франшизе!
            </p>
            <a class="promo__link" href="#">
              Подробнее
            </a>
          </article>
          <article class="promo__block promo__block--technomart">
            <h2 class="visually-hidden">Рекламный блок</h2>
            <p class="promo__text">
              Товары будущего уже сегодня в онлайн-сторе Техномарт!
            </p>
            <a class="promo__link" href="#">
              Перейти в магазин
            </a>
          </article>
          <article class="promo__block">
            <h2 class="visually-hidden">Рекламный блок</h2>
            <p class="promo__text">
              Здесь<br> могла быть<br> ваша реклама
            </p>
            <a class="promo__link" href="#">
              Разместить
            </a>
          </article>
        </aside>
      </div>
    </main>

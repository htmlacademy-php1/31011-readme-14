              <section class="profile__posts tabs__content tabs__content--active">
                <h2 class="visually-hidden">Публикации</h2>
                <?php foreach($posts as $post):?>
                <article class="profile__post post post-<?=strip_tags($post['type']);?>">
                  <header class="post__header">
                    <h2><a href="post.php?id=<?=$post['id'];?>"><?=htmlspecialchars($post['header']);?></a></h2>
                  </header>
                  <div class="post__main">
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
                  <footer class="post__footer">
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
                        <a class="post__indicator post__indicator--repost button" href="#" title="Репост">
                          <svg class="post__indicator-icon" width="19" height="17">
                            <use xlink:href="#icon-repost"></use>
                          </svg>
                          <span>5</span>
                          <span class="visually-hidden">количество репостов</span>
                        </a>
                      </div>
                      <time class="post__time" datetime="<?=strip_tags($post['date']);?>"><?=convert_date_relative_format($post['date'])?> назад</time>
                    </div>
                    <ul class="post__tags">
                      <?php foreach($post['tags'] as $tag):?>
                        <li><a href="search.php?search=%23<?=strip_tags($tag);?>">#<?=strip_tags($tag);?></a></li>
                      <?php endforeach;?>
                    </ul>
                  </footer>
                  <div class="comments">
                    <a class="comments__button button" href="post.php?id=<?=strip_tags($post['id']);?>#comments">Показать комментарии</a>
                  </div>
                </article>
                <?php endforeach;?>
              </section>



<section class="profile__likes tabs__content tabs__content--active">
                <h2 class="visually-hidden">Лайки</h2>
                <ul class="profile__likes-list">
                <?php foreach($likes as $like):?>
                  <li class="post-mini post-mini--text post user">
                    <div class="post-mini__user-info user__info">
                      <div class="post-mini__avatar user__avatar">
                        <a class="user__avatar-link" href="profile.php?user_id=<?=$like['user_id']?>">
                          <img class="post-mini__picture user__picture" src="<?php if (!empty($like['avatar'])):?>uploads/<?=$like['avatar'];?><?php endif; ?>" alt="Аватар пользователя">
                        </a>
                      </div>
                      <div class="post-mini__name-wrapper user__name-wrapper">
                        <a class="post-mini__name user__name" href="profile.php?user_id=<?=$like['user_id']?>">
                          <span><?=$like['login']?></span>
                        </a>
                        <div class="post-mini__action">
                          <span class="post-mini__activity user__additional">Лайкнул вашу публикацию</span>
                          <time class="post-mini__time user__additional" datetime="<?=strip_tags($like['date_like']);?>"><?=convert_date_relative_format($like['date_like'])?> назад</time>
                        </div>
                      </div>
                    </div>
                    <div class="post-mini__preview">
                      <a class="post-mini__link" href="post.php?id=<?=$like['post_id']?>" title="Перейти на публикацию">
                        <span class="visually-hidden">Текст</span>
                        <svg class="post-mini__preview-icon" width="20" height="21">
                          <use xlink:href="#icon-filter-<?=$like['type_post']?>"></use>
                        </svg>
                      </a>
                    </div>
                  </li>
                <?php endforeach;?>
                </ul>
              </section>

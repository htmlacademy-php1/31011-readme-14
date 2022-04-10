<section class="profile__subscriptions tabs__content tabs__content--active">
                <h2 class="visually-hidden">Подписки</h2>
                <ul class="profile__subscriptions-list">
                <?php foreach ($subscribeds as $subscribed):?>
                  <li class="post-mini post-mini--photo post user">
                    <div class="post-mini__user-info user__info">
                      <div class="post-mini__avatar user__avatar">
                        <a class="user__avatar-link" href="profile.php?user_id=<?=$subscribed['id']?>">
                          <img class="post-mini__picture user__picture" src="<?php if (!empty($subscribed['avatar'])):?>uploads/<?=$subscribed['avatar'];?><?php endif; ?>" alt="Аватар пользователя">
                        </a>
                      </div>
                      <div class="post-mini__name-wrapper user__name-wrapper">
                        <a class="post-mini__name user__name" href="profile.php?user_id=<?=$subscribed['id']?>">
                          <span><?=$subscribed['login'];?></span>
                        </a>
                        <time class="post-mini__time user__additional" datetime="<?=strip_tags($subscribed['reg_date']);?>"><?=convert_date_relative_format($subscribed['reg_date'])?> на сайте</time>
                      </div>
                    </div>
                    <div class="post-mini__rating user__rating">
                      <p class="post-mini__rating-item user__rating-item user__rating-item--publications">
                        <span class="post-mini__rating-amount user__rating-amount"><?=$subscribed['posts']?></span>
                        <span class="post-mini__rating-text user__rating-text">публикаций</span>
                      </p>
                      <p class="post-mini__rating-item user__rating-item user__rating-item--subscribers">
                        <span class="post-mini__rating-amount user__rating-amount"><?=$subscribed['subscribed']?></span>
                        <span class="post-mini__rating-text user__rating-text">подписчиков</span>
                      </p>
                    </div>

                    <div class="post-mini__user-buttons user__buttons">
                    <?php if ($_SESSION['user_id'] !== $user_id):?>
                        <?php if ($subscribed['me_subscribed'] == 0):?>
                          <a class="post-mini__user-button user__button user__button--subscription button button--main" href="subscription.php?user_id=<?=$subscribed['id']?>">Подписаться</a>
                        <?php else:?>
                            <a class="post-mini__user-button user__button user__button--subscription button button--quartz" href="subscription.php?user_id=<?=$subscribed['id']?>">Отписаться</a>  
                        <?php endif;?>
                    <?php else:?>
                        <a class="post-mini__user-button user__button user__button--subscription button button--quartz" href="subscription.php?user_id=<?=$subscribed['id']?>">Отписаться</a>
                    <?php endif;?>
                    </div>

                  </li>
                <?php endforeach;?>
                </ul>
              </section>
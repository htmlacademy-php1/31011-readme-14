<main class="page__main page__main--messages">
      <h1 class="visually-hidden">Личные сообщения</h1>
      <section class="messages tabs">
        <h2 class="visually-hidden">Сообщения</h2>
        <div class="messages__contacts">
          <ul class="messages__contacts-list tabs__list">
            <?php foreach($contacts as $contact):?>
                <li class="messages__contacts-item">
              <a class="messages__contacts-tab tabs__item <?php if ($user_id === $contact['id']):?>messages__contacts-tab--active tabs__item--active<?php endif;?>" href="messages.php?user_id=<?=$contact['id'];?>">
                <div class="messages__avatar-wrapper">
                    <?php if (!empty($contact['avatar'])):?>
                        <img class="messages__avatar" src="uploads/<?=$contact['avatar'];?>" alt="Аватар пользователя">
                    <?php endif; ?>
                    <?php if ($contact['not_read'] != 0):?>
                        <i class="messages__indicator"><?=$contact['not_read'];?></i>
                    <?php endif; ?>
                </div>
                <div class="messages__info">
                  <span class="messages__contact-name">
                        <?=strip_tags($contact['login']);?>
                  </span>
                  <div class="messages__preview">
                    <p class="messages__preview-text">
                      <?=cropping_text(strip_tags($contact['message']), 10);?>
                    </p>
                    <time class="messages__preview-time" datetime="<?=strip_tags($contact['message_date']);?>">
                        <?=convert_date_relative_format($contact['message_date'])?>
                    </time>
                  </div>
                </div>
              </a>
            </li>
            <?php endforeach;?>
          </ul>
        </div>
        <div class="messages__chat">
          <div class="messages__chat-wrapper">
            <ul class="messages__list tabs__content tabs__content--active">
            <?php foreach($messages as $message):?>
              <li class="messages__item <?php if ($message['id'] === $_SESSION['user_id']):?>messages__item--my<?php endif;?>">
                <div class="messages__info-wrapper">
                  <div class="messages__item-avatar">
                    <a class="messages__author-link" href="profile.php?user_id=<?=strip_tags($message['id']);?>">
                        <?php if (!empty($message['avatar'])):?>
                            <img class="messages__avatar" src="uploads/<?=$message['avatar'];?>" alt="Аватар пользователя">
                        <?php endif; ?>
                    </a>
                  </div>
                  <div class="messages__item-info">
                    <a class="messages__author" href="profile.php?user_id=<?=strip_tags($message['id']);?>">
                    <?=strip_tags($message['login']);?>
                    </a>
                    <time class="messages__time" datetime="<?=strip_tags($message['date']);?>">
                        <?=convert_date_relative_format($message['date'])?> назад
                    </time>
                  </div>
                </div>
                <p class="messages__text">
                    <?=strip_tags($message['message']);?>
                </p>
              </li>
              <?php endforeach;?>
            </ul>
          </div>
          <div class="comments">
            <?php if ($error_message === false and !empty($user_id)):?>
            <form class="comments__form form" action="messages.php?user_id=<?=strip_tags($user_id);?>" method="post">
                <input type="hidden" name="user_id" value="<?=strip_tags($user_id);?>">
              <div class="comments__my-avatar">
                <?php if (!empty($_SESSION['avatar'])):?>
                    <img class="comments__picture" src="uploads/<?=$_SESSION['avatar'];?>" alt="Аватар пользователя">
                <?php endif;?>
              </div>
              <div class="form__input-section <?php if(!empty($errors['message'])):?>form__input-section--error<?php endif;?>">
                <textarea class="comments__textarea form__textarea form__input" name="message"
                          placeholder="Ваше сообщение"></textarea>
                <label class="visually-hidden">Ваше сообщение</label>
                <button class="form__error-button button" type="button">!</button>
                <div class="form__error-text">
                  <h3 class="form__error-title"><?= (!empty($errors['message']['header'])) ? $errors['message']['header'] : ''; ?></h3>
                  <p class="form__error-desc"><?= (!empty($errors['message']['text'])) ? $errors['message']['text'] : ''; ?></p>
                </div>
              </div>
              <button class="comments__submit button button--green" type="submit">Отправить</button>
            </form>
            <?php else:?>
                У вас нет сообщений
            <?php endif;?>
          </div>
        </div>
      </section>
    </main>

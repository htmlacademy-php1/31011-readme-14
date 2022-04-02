    <main class="page__main page__main--adding-post">
      <div class="page__main-section">
        <div class="container">
          <h1 class="page__title page__title--adding-post">Добавить публикацию</h1>
        </div>
        <div class="adding-post container">
          <div class="adding-post__tabs-wrapper tabs">
            <div class="adding-post__tabs filters">
              <ul class="adding-post__tabs-list filters__list tabs__list">
              <?php foreach ($content_types as $type):?>
              <li class="adding-post__tabs-item filters__item">
                  <a class="adding-post__tabs-link filters__button filters__button--<?=$type['type'];?> <?php if ($ctype == $type['id']):?>filters__button--active<?php endif;?> tabs__item tabs__item--active button" href="add.php?ctype=<?=$type['id']?>">
                    <svg class="filters__icon" width="22" height="18">
                      <use xlink:href="#icon-filter-<?=$type['type'];?>"></use>
                    </svg>
                    <span><?=$type['name'];?></span>
                  </a>
                </li>
                <?php endforeach;?>
              </ul>
            </div>
            <div class="adding-post__tab-content">
            <?php if ($ctype_name === 'photo'):?>
              <section class="adding-post__photo tabs__content tabs__content--active">
                <h2 class="visually-hidden">Форма добавления фото</h2>
                <form class="adding-post__form form" action="add.php?ctype=<?=$ctype?>" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="ctype" value="<?=$ctype?>">
                  <div class="form__text-inputs-wrapper">
                    <div class="form__text-inputs">
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="photo-heading">Заголовок <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?php if(!empty($errors['header'])):?>form__input-section--error<?php endif;?>">
                          <input class="adding-post__input form__input" id="photo-heading" type="text" name="header" placeholder="Введите заголовок" value="<?= (!empty($data_post['header'])) ? $data_post['header'] : ''; ?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title"><?= (!empty($errors['header']['header'])) ? $errors['header']['header'] : ''; ?></h3>
                            <p class="form__error-desc"><?= (!empty($errors['header']['text'])) ? $errors['header']['text'] : ''; ?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="photo-url">Ссылка из интернета</label>
                        <div class="form__input-section <?php if(!empty($errors['photo'])):?>form__input-section--error<?php endif;?>">
                          <input class="adding-post__input form__input" id="photo-url" type="text" name="photo_link" placeholder="Введите ссылку" value="<?= (!empty($data_post['filter_url'])) ? $data_post['filter_url'] : ''; ?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title"><?= (!empty($errors['photo']['header'])) ? $errors['photo']['header'] : ''; ?></h3>
                            <p class="form__error-desc"><?= (!empty($errors['photo']['text'])) ? $errors['photo']['text'] : ''; ?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="photo-tags">Теги</label>
                        <div class="form__input-section <?php if(!empty($errors['tags'])):?>form__input-section--error<?php endif;?>">
                          <input class="adding-post__input form__input" id="photo-tags" type="text" name="tags" placeholder="Введите теги" value="<?= (!empty($data_post['tags'])) ? $data_post['tags'] : ''; ?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title"><?= (!empty($errors['tags']['header'])) ? $errors['tags']['header'] : ''; ?></h3>
                            <p class="form__error-desc"><?= (!empty($errors['tags']['text'])) ? $errors['tags']['text'] : ''; ?></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="adding-post__input-file-container form__input-container form__input-container--file">
                    <div class="adding-post__input-file-wrapper form__input-file-wrapper">
                      <div class="adding-post__file-zone adding-post__file-zone--photo form__file-zone dropzone">
                        <input class="adding-post__input-file form__input-file" id="userpic-file-photo" type="file" name="uploadfile" title=" ">
                        <div class="form__file-zone-text">
                          <span>Перетащите фото сюда</span>
                        </div>
                      </div>
                      <button class="adding-post__input-file-button form__input-file-button form__input-file-button--photo button" type="button">
                        <span>Выбрать фото</span>
                        <svg class="adding-post__attach-icon form__attach-icon" width="10" height="20">
                          <use xlink:href="#icon-attach"></use>
                        </svg>
                      </button>
                    </div>
                    <div class="adding-post__file adding-post__file--photo form__file dropzone-previews">

                    </div>
                  </div>
            <?php elseif ($ctype_name === 'video'):?>
              <section class="adding-post__video tabs__content tabs__content--active">
                <h2 class="visually-hidden">Форма добавления видео</h2>
                <form class="adding-post__form form" action="add.php?ctype=<?=$ctype?>" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="ctype" value="<?=$ctype?>">
                  <div class="form__text-inputs-wrapper">
                    <div class="form__text-inputs">
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="video-heading">Заголовок <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?php if(!empty($errors['header'])):?>form__input-section--error<?php endif;?>">
                          <input class="adding-post__input form__input" id="video-heading" type="text" name="header" placeholder="Введите заголовок" value="<?= (!empty($data_post['header'])) ? $data_post['header'] : ''; ?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title"><?= (!empty($errors['header']['header'])) ? $errors['header']['header'] : ''; ?></h3>
                            <p class="form__error-desc"><?= (!empty($errors['header']['text'])) ? $errors['header']['text'] : ''; ?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="video-url">Ссылка youtube <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?php if(!empty($errors['video_link'])):?>form__input-section--error<?php endif;?>">
                          <input class="adding-post__input form__input" id="video-url" type="text" name="video_link" placeholder="Введите ссылку" value="<?= (!empty($data_post['filter_url'])) ? $data_post['filter_url'] : ''; ?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title"><?= (!empty($errors['video_link']['header'])) ? $errors['video_link']['header'] : ''; ?></h3>
                            <p class="form__error-desc"><?= (!empty($errors['video_link']['text'])) ? $errors['video_link']['text'] : ''; ?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="video-tags">Теги</label>
                        <div class="form__input-section <?php if(!empty($errors['tags'])):?>form__input-section--error<?php endif;?>">
                          <input class="adding-post__input form__input" id="video-tags" type="text" name="tags" placeholder="Введите теги" value="<?= (!empty($data_post['tags'])) ? $data_post['tags'] : ''; ?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title"><?= (!empty($errors['tags']['header'])) ? $errors['tags']['header'] : ''; ?></h3>
                            <p class="form__error-desc"><?= (!empty($errors['tags']['text'])) ? $errors['tags']['text'] : ''; ?></p>
                          </div>
                        </div>
                      </div>
                    </div>
            <?php elseif ($ctype_name === 'text'):?>
              <section class="adding-post__text tabs__content tabs__content--active">
                <h2 class="visually-hidden">Форма добавления текста</h2>
                <form class="adding-post__form form" action="add.php?ctype=<?=$ctype?>" method="post">
                  <input type="hidden" name="ctype" value="<?=$ctype?>">
                  <div class="form__text-inputs-wrapper">
                    <div class="form__text-inputs">
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="text-heading">Заголовок <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?php if(!empty($errors['header'])):?>form__input-section--error<?php endif;?>">
                          <input class="adding-post__input form__input" id="text-heading" type="text" name="header" placeholder="Введите заголовок" value="<?= (!empty($data_post['header'])) ? $data_post['header'] : ''; ?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title"><?= (!empty($errors['header']['header'])) ? $errors['header']['header'] : ''; ?></h3>
                            <p class="form__error-desc"><?= (!empty($errors['header']['text'])) ? $errors['header']['text'] : ''; ?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__textarea-wrapper form__textarea-wrapper">
                        <label class="adding-post__label form__label" for="post-text">Текст поста <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?php if(!empty($errors['post'])):?>form__input-section--error<?php endif;?>">
                          <textarea class="adding-post__textarea form__textarea form__input" id="post-text" name="post" placeholder="Введите текст публикации"><?= (!empty($data_post['post'])) ? $data_post['post'] : ''; ?></textarea>
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title"><?= (!empty($errors['post']['header'])) ? $errors['post']['header'] : ''; ?></h3>
                            <p class="form__error-desc"><?= (!empty($errors['post']['text'])) ? $errors['post']['text'] : ''; ?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="post-tags">Теги</label>
                        <div class="form__input-section <?php if(!empty($errors['tags'])):?>form__input-section--error<?php endif;?>">
                          <input class="adding-post__input form__input" id="post-tags" type="text" name="tags" placeholder="Введите теги" value="<?= (!empty($data_post['tags'])) ? $data_post['tags'] : ''; ?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title"><?= (!empty($errors['tags']['header'])) ? $errors['tags']['header'] : ''; ?></h3>
                            <p class="form__error-desc"><?= (!empty($errors['tags']['text'])) ? $errors['tags']['text'] : ''; ?></p>
                          </div>
                        </div>
                      </div>
                    </div>
            <?php elseif ($ctype_name === 'quote'):?>
              <section class="adding-post__quote tabs__content tabs__content--active">
                <h2 class="visually-hidden">Форма добавления цитаты</h2>
                <form class="adding-post__form form" action="add.php?ctype=<?=$ctype?>" method="post">
                  <input type="hidden" name="ctype" value="<?=$ctype?>">
                  <div class="form__text-inputs-wrapper">
                    <div class="form__text-inputs">
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="quote-heading">Заголовок <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?php if(!empty($errors['header'])):?>form__input-section--error<?php endif;?>">
                          <input class="adding-post__input form__input" id="quote-heading" type="text" name="header" placeholder="Введите заголовок" value="<?= (!empty($data_post['header'])) ? $data_post['header'] : ''; ?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title"><?= (!empty($errors['header']['header'])) ? $errors['header']['header'] : ''; ?></h3>
                            <p class="form__error-desc"><?= (!empty($errors['header']['text'])) ? $errors['header']['text'] : ''; ?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__textarea-wrapper">
                        <label class="adding-post__label form__label" for="cite-text">Текст цитаты <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?php if(!empty($errors['post'])):?>form__input-section--error<?php endif;?>">
                          <textarea class="adding-post__textarea adding-post__textarea--quote form__textarea form__input" id="cite-text" name="post" placeholder="Текст цитаты"><?= (!empty($data_post['post'])) ? $data_post['post'] : ''; ?></textarea>
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title"><?= (!empty($errors['post']['header'])) ? $errors['post']['header'] : ''; ?></h3>
                            <p class="form__error-desc"><?= (!empty($errors['post']['text'])) ? $errors['post']['text'] : ''; ?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__textarea-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="quote-author">Автор <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?php if(!empty($errors['author_quote'])):?>form__input-section--error<?php endif;?>">
                          <input class="adding-post__input form__input" id="quote-author" type="text" name="author_quote" placeholder="Автор цитаты" value="<?= (!empty($data_post['author_quote'])) ? $data_post['author_quote'] : ''; ?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title"><?= (!empty($errors['author_quote']['header'])) ? $errors['author_quote']['header'] : ''; ?></h3>
                            <p class="form__error-desc"><?= (!empty($errors['author_quote']['text'])) ? $errors['author_quote']['text'] : ''; ?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="cite-tags">Теги</label>
                        <div class="form__input-section <?php if(!empty($errors['tags'])):?>form__input-section--error<?php endif;?>">
                          <input class="adding-post__input form__input" id="cite-tags" type="text" name="tags" placeholder="Введите теги" value="<?= (!empty($data_post['tags'])) ? $data_post['tags'] : ''; ?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title"><?= (!empty($errors['tags']['header'])) ? $errors['tags']['header'] : ''; ?></h3>
                            <p class="form__error-desc"><?= (!empty($errors['tags']['text'])) ? $errors['tags']['text'] : ''; ?></p>
                          </div>
                        </div>
                      </div>
                    </div>
            <?php elseif ($ctype_name === 'link'):?>
              <section class="adding-post__link tabs__content tabs__content--active">
                <h2 class="visually-hidden">Форма добавления ссылки</h2>
                <form class="adding-post__form form" action="add.php?ctype=<?=$ctype?>" method="post">
                  <input type="hidden" name="ctype" value="<?=$ctype?>">
                  <div class="form__text-inputs-wrapper">
                    <div class="form__text-inputs">
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="link-heading">Заголовок <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?php if(!empty($errors['header'])):?>form__input-section--error<?php endif;?>">
                          <input class="adding-post__input form__input" id="link-heading" type="text" name="header" placeholder="Введите заголовок" value="<?= (!empty($data_post['header'])) ? $data_post['header'] : ''; ?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title"><?= (!empty($errors['header']['header'])) ? $errors['header']['header'] : ''; ?></h3>
                            <p class="form__error-desc"><?= (!empty($errors['header']['text'])) ? $errors['header']['text'] : ''; ?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__textarea-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="post-link">Ссылка <span class="form__input-required">*</span></label>
                        <div class="form__input-section <?php if(!empty($errors['site_link'])):?>form__input-section--error<?php endif;?>">
                          <input class="adding-post__input form__input" id="post-link" type="text" name="site_link" placeholder="Введите ссылку" value="<?= (!empty($data_post['filter_url'])) ? $data_post['filter_url'] : ''; ?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title"><?= (!empty($errors['site_link']['header'])) ? $errors['site_link']['header'] : ''; ?></h3>
                            <p class="form__error-desc"><?= (!empty($errors['site_link']['text'])) ? $errors['site_link']['text'] : ''; ?></p>
                          </div>
                        </div>
                      </div>
                      <div class="adding-post__input-wrapper form__input-wrapper">
                        <label class="adding-post__label form__label" for="link-tags">Теги</label>
                        <div class="form__input-section <?php if(!empty($errors['tags'])):?>form__input-section--error<?php endif;?>">
                          <input class="adding-post__input form__input" id="link-tags" type="text" name="tags" placeholder="Введите теги" value="<?= (!empty($data_post['tags'])) ? $data_post['tags'] : ''; ?>">
                          <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                          <div class="form__error-text">
                            <h3 class="form__error-title"><?= (!empty($errors['tags']['header'])) ? $errors['tags']['header'] : ''; ?></h3>
                            <p class="form__error-desc"><?= (!empty($errors['tags']['text'])) ? $errors['tags']['text'] : ''; ?></p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php endif;?>
                    <?php if ($errors):?>
                    <div class="form__invalid-block">
                      <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                      <ul class="form__invalid-list">
                        <?php foreach($errors as $error):?>
                            <li class="form__invalid-item"><strong><?php if(!empty($error)): echo $error['header'] . "</strong><BR>" . $error['text']; endif;?></li>
                        <?php endforeach;?>
                      </ul>
                    </div>
                    <?php endif;?>
                  </div>
                  <div class="adding-post__buttons">
                    <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
                    <a class="adding-post__close" href="#">Закрыть</a>
                  </div>
                </form>
              </section>
            </div>
          </div>
        </div>
      </div>
    </main>

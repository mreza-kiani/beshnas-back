<?php
/**
 * Created by PhpStorm.
 * User: arash
 * Date: 8/13/16
 * Time: 6:44 PM
 */

return [
    'auth' => [
        'login_needed' => 'برای ورود به این قسمت باید وارد سیستم شوید',
        'not_logged_in' => 'هنوز وارد سیستم نشده اید',
        'user_not_found' => 'کاربر مورد نظر شما در سیستم موجود نیست',
        'token_expired' => 'ورود شما به سیستم منقضی شده است، لطفا مجددا وارد سیستم شوید',
        'token_invalid' => 'توکن ارسالی غیر مجاز است',
        'token_absent' => 'توکن در سیستم موجود نیست',
        'token_is_valid' => 'شناسایی کاربر :name انجام شد ، خوش آمدید',
        'login_successful' => 'ورود شما با موفقیت انجام شد',
        'invalid_credentials' => 'نام کاربری و یا کلمه ی عبور اشتباه است',
        'wrong_old_password' => 'کلمه ی عبور قدیمی اشتباه است',
        'change_password_done' => 'تغییر کلمه ی عبور با موفقیت انجام شد',
        'email_not_found' => 'هیچ کاربری با ایمیل :email یافت نشد.',
        'change_password_mail_sent' => 'ایمیل حاوی لینک تغییر کلمه ی عبور ارسال شد ، صندوق دریافت خود را بررسی کنید',
        'mail_send_error' => 'ارسال ایمیل با مشکل مواجه شد ، با اپراتور سیستم تماس بگیرید',
        'reset_password_successful' => 'تغییر کلمه ی عبور با موفقیت انجام شد',
        'chpass_token_expired' => 'لینک ارسال شده غیر فعال شده است ، لطفا دوباره برای دریافت ایمیل اقدام فرمایید.',
        'action_not_permitted' => 'انجام این عملیات برای شما غیر مجاز است',
        'profile_edited' => 'ویرایش پروفایل با موفقیت انجام شد',
        'image_changed' => 'عکس پروفایل با موفقیت تعویض شد',
        'image_removed' => 'عکس پروفایل با موفقیت حذف شد',
    ],
    'user' => [
        'user_added' => 'کاربر با موفقیت اضافه شد',
        'email_exists' => 'کاربر با این ایمیل قبلا ثبت شده است',
        'user_edited' => 'ویرایش کاربر با موفقیت انجام شد',
    ],
    'role' => [
        'name_exists' => 'این سطح دسترسی قبلا ایجاد شده است',
        'role_added' => 'سطح دسترسی با موفقیت ایجاد شد',
        'role_not_exists' => 'این سطح دسترسی در سیستم وجود ندارد',
        'role_edited' => 'سطح دسترسی ویرایش شد',
    ],
    'task' => [
        'task_added' => 'کار با موفقیت اضافه شد',
        'task_edited' => 'ویرایش کار با موفقیت انجام شد',
        'task_removed' => 'کار با موفقیت حذف شد',
        'not_allowed' => 'شما مجاز به مشاهده این کار نیستید',
        'not_creator' => 'شما مجاز به بستن یا از سر گیری مجدد این کار نیستید',
        'status_changed' => 'تغییر وضعیت با موفقیت انجام شد',
        'close_state_changed' => 'وضعیت بسته بودن کار تغییر کرد',
        'is_closed' => 'این کار توسط ایجاد کننده بسته شده است. بنابراین امکان تغییر وضعیت کار وجود ندارد'
    ],
    'tag' => [
        'tag_added' => 'تگ با موفقیت ایجاد شد',
        'name_exists' => 'تگی با این مشخصات وجود دارد',
        'tag_edited' => 'تگ با موفقیت ویرایش شد',
        'tag_removed' => 'تگ با موفقیت حذف شد',
        'tag_not_exists' => 'تگی با این مشخصات وجود ندارد',
    ],
    'notifications' => [
        'trans_bug' => "مشکل در قسمت ترجمه ها",
        'edit_model' => [
            'Task' => [
                'title' => 'ایجاد تغییر در کار',
                'description' => ":user_name کاری با عنوان ' :model_title ' را ویرایش کرده است."
            ]
        ],
        'add_model' => [
            'Task' => [
                "title" => "کار جدید",
                "description" => ":user_name برای شما یک وظیفه جدید با عنوان ' :model_title ' ایجاد کرده است",
            ],
            'Comment' => [
                "title" => "نظر جدید",
                "description" => ":user_name نظر جدید برای شما ارسال کرده است",
            ],
            'BroadcastNote' => [
                "title" => "پیام جدید",
                "description" => ":user_name یک پیام جدید در بخش :category_name ایجاد کرده است"
            ]
        ],
        'remove_model' => [
            'Task' => [
                'title' => 'حدف کار',
                'description' => ":user_name وظیفه ی ' :model_title ' را حذف کرده است",
            ]
        ],
        'done_model' => [
            'Task' => [
                'title' => 'تایید انجام کار',
                'description' => ":user_name کار انجام شده توسط شما با عنوان ' :model_title ' را تایید کرد."
            ]
        ],
        'stch_model' => [
            'Task' => [
                'title' => 'تغییر وضعیت کار',
                'description' => ":user_name در وضعیت کار با عنوان ' :model_title ' تغییر ایجاد کرده است"
            ]
        ],
        'fstch_model' => [
            'Task' => [
                'title' => 'تغییر وضعیت کار',
                'description' => ":user_name در وضعیت کار دنبال شده با عنوان ' :model_title ' تغییر ایجاد کرده است"
            ]
        ],
        'follow_model' => [
            'Task' => [
                'title' => 'اضافه شدن به عنوان دنبال کننده',
                'description' => ":user_name شما را در کار به عوان ' :model_title ' به عنوان دنبال کننده اضافه کرده است"
            ]
        ],
        'tag_model' => [
            'Comment' => [
                'title' => 'تگ شدن در نظر',
                'description' => ':user_name شما را در نظر خود تگ کرده است'
            ]
        ]
    ],
    'contact' => [
        'type_not_exists' => 'این نوع داده ی ارسالی از مشخصات یک مخاطب نیست',
        'contact_added' => 'مخاطب با موفقیت ایجاد شد',
        'contact_removed' => 'مخاطب با موفقیت حذف شد',
        'contact_edited' => 'مخاطب با موفقیت ویرایش شد',
        'image_changed' => 'عکس مخاطب با موفقیت تعویض شد',
        'image_removed' => 'عکس مخاطب با موفقیت حذف شد',
        'is_private' => 'متسفانه شما به این مخاطب دسترسی ندارید',
    ],
    'to_do_list' => [
        'to_do_added' => 'کار افزوده شد',
        'to_do_edited' => 'کار ویرایش شد',
        'to_do_removed' => 'کار حذف شد',
        'state_changed' => 'وضعیت کار تغییر کرد',
        'not_your_to_do' => 'این کار متعلق به شما نیست',
        'toggle_important' => 'اهمیت کار تغییر کرد',
    ],
    'comment' => [
        'comment_added' => 'یادداشت با موفقیت ایجاد شد',
        'comment_edited' => 'یادداشت با موفقیت ویرایش شد',
        'comment_removed' => 'یادداشت با موفقیت حذف شد',
        'not_comment_owner' => 'متاسفانه شما ایجاد کننده ی یادداشت نیستید و نمیتوانید آن را تغییر دهید',
    ],
    'prefix' => [
        'prefix_added' => 'پیشوند با موفقیت اضافه شد',
        'prefix_edited' => 'پیشوند با موفقیت ویرایش شد',
        'prefix_removed' => 'پیشوند با موفقیت حذف شد',
        'name_exists' => 'این پیشوند قبلا ایجاد شده است',
    ],
    'broadcast_note' => [
        'note_added' => 'پیام با موفقیت منتشر شد',
        'note_edited' => 'محتوای پیام با موفقیت ویرایش شد',
        'note_removed' => 'پیام با موفقیت حدف شد',
        'not_your_note' => 'این پیام متعلق به شما نیست',
        'has_ended' => 'تاریخ پایان این پیام گذشته است',
    ],
    'note_category' => [
        'category_added' => 'دسته با موفقیت اضافه شد',
        'category_edited' => 'دسته با موفقیت ویرایش شد',
        'category_removed' => 'دسته با موفقیت حذف شد',
        'name_exists' => 'این دسته قبلا ایجاد شده است',
    ],
    'attach_file' => [
        'added_to_model' => 'فایل با موفقیت به مدل اضافه شده',
        'not_added_to_model' => 'متاسفانه مشکلی در اضافه شدن فایل به مدل پیش آمد',
        'not_your_attachment' => 'این فایل متعلق به شما نیست',
        'removed_from_model' => 'فایل با موفقیت از مدل حذف شد'
    ],
    'task_board' => [
        'unknown' => 'فرایند تعریف نشده است',
        'follower_added' => 'دنبال کننده با موفقیت به فرایند اضافه شد',
        'follower_detached' => 'دنبال کننده با موفقیت از فرایند حذف شد',
        'not_your_follower' => 'این دنبال کننده به شما تعلق ندارد'
    ]
];
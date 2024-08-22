<?php

namespace App\Services\Components;

use Filament\Forms\Set;
use Illuminate\Support\Str;
use App\Services\Enums\Status;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\ColorPicker;

class FormComponents
{
    public static function ogTitleTextInput()
    {
        return TextInput::make('og_title')
            ->label('Facebook Title')
            ->placeholder('Enter Open Graph Facebook Title')->columnSpanFull();
    }
    public static function ogDescriptionTextarea()
    {
        return Textarea::make('og_description')
            ->label('Facebook Description')
            ->placeholder('Enter Open Graph Facebook Description')->columnSpanFull();
    }
    public static function ogImageFileUpload($directory)
    {
        return FileUpload::make('og_image')
            ->image()
            ->label('Facebook Image')
            ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml', 'image/webp'])
            ->imageEditor()
            ->imageEditorAspectRatios([
                '2:1',
            ])
            ->directory($directory)
            ->preserveFilenames()

            ->columnSpanFull();
    }
    public static function twitterCardSelect()
    {
        return Select::make('twitter_card')
            ->label('Twitter Card')
            ->options([
                'summary' => 'summary',
                'summary_large_image' => 'summary_large_image',
                'app' => 'app',
            ])
            ->default('summary_large_image')
            ->columnSpanFull();
    }
    public static function twitterTitleTextInput()
    {
        return TextInput::make('twitter_title')
            ->label('Twitter Title')
            ->placeholder('Enter Twitter Title')->columnSpanFull();
    }
    public static function twitterDescriptionTextarea()
    {
        return Textarea::make('twitter_description')
            ->label('Twitter Description')
            ->placeholder('Enter Twitter Description')->columnSpanFull();
    }
    public static function twitterImageFileUpload($directory)
    {
        return FileUpload::make('twitter_image')
            ->image()
            ->label('Twitter Image')

            ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml', 'image/webp'])
            ->imageEditor()
            ->directory($directory)
            ->preserveFilenames()
            ->imageEditorAspectRatios([
                '2:1',
            ])
            ->columnSpanFull();
    }

    public static function schemaJsonTextarea()
    {
        return RichEditor::make('schema_json')
            ->label('Schema JSON')
            ->placeholder('Enter Schema JSON')->columnSpanFull();
    }
    public static function statusSelect()
    {
        return Select::make('status')
            ->label('Status')
            // ->options([
            //     'publish' => 'Publish',
            //     'draft' => 'Draft',
            //     'trash' => 'Trash',
            // ])
            ->options(Status::class)
            ->default('published')
            ->placeholder('Select Status')
            ->searchable()
            ->preload()
            ->visibleOn(['edit', 'view']);
        //->columnSpanFull();
    }
    //page image
    public static function imageFileUpload($directory)
    {
        return Repeater::make('image')->label('Upload Image')->schema([
            FileUpload::make('path')
                ->image()
                ->label('Image')

                ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml', 'image/webp'])
                ->imageEditor()
                ->preserveFilenames()
                ->directory($directory)
                ->imageEditorAspectRatios([
                    '16:9',
                ]),
            TextInput::make('alt')->label('Alt'),
        ])->addable(false)->reorderable(false)->deletable(false);
    }

    public static function isActiveToggle()
    {
        return Toggle::make('is_active')
            ->label('Is Active')
            ->default(true)
            ->visibleOn('edit')
            ->columnSpanFull();
    }

    public static function contentRichEditor()
    {
        return RichEditor::make('content')
            ->label('Content')
            ->placeholder('Enter Content')

            ->columnSpanFull();
    }
    public static function titleTextInput()
    {
        return TextInput::make('title')
            ->label('Title')
            ->extraAttributes(['title' => 'Text input'])
            ->placeholder('Enter Title')->required()
            ->afterStateUpdated(fn (String $operation, $state, Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
            ->live(onBlur: true);
    }
    public static function subtitleTextInput()
    {
        return TextInput::make('subtitle')
            ->label('Subtitle')
            ->placeholder('Enter Subtitle');
    }

    public static function slugTextInput()
    {
        return TextInput::make('slug')
            ->label('Slug')
            ->disabled()
            ->dehydrated()
            ->unique(ignoreRecord: true)
            ->placeholder('Enter Slug')->required();
    }
    public static function excerptTextarea()
    {
        return Textarea::make('excerpt')
            ->label('Excerpt')
            ->placeholder('Enter Excerpt')->columnSpanFull();
    }
    public static function stackImageFileUpload()
    {
        return Repeater::make('image')->label('Upload Image')->schema([
            FileUpload::make('path')
                ->image()
                ->label('Image')

                ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml', 'image/webp'])
                ->imageEditor()
                ->imageEditorAspectRatios([
                    '1:1',
                ])
                ->directory('stacks')
                ->preserveFilenames(),
            TextInput::make('alt')->label('Alt'),
        ])->addable(false)->reorderable(false)->deletable(false);
    }
    public static function imageTechnologyFileUpload()
    {
        return Repeater::make('image')->label('Upload Image')->schema([
            FileUpload::make('path')
                ->label('Image')
                ->image()
                ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml', 'image/webp'])
                ->imageEditor()
                ->imageEditorAspectRatios([
                    '3:2',
                ])
                ->directory('technologies')
                ->preserveFilenames(),
            TextInput::make('alt')->label('Alt'),
        ])->addable(false)->reorderable(false)->deletable(false);
    }

    public static function galleryFileUpload($directory)
    {
        return Repeater::make('gallery')->label('Gallery')->schema([
            FileUpload::make('path')
                ->image()
                ->label('Galleries')

                ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml', 'image/webp'])
                ->imageEditor()
                ->preserveFilenames()
                ->imageEditorAspectRatios([
                    '16:9',
                ])
                ->directory($directory),
            TextInput::make('alt')->label('Alt'),

        ])->addable(true)->reorderable(true)->maxItems(5);
    }
    public static function videoFileUpload($directory)
    {
        return FileUpload::make('video')
            ->image()
            ->label('Video')

            ->preserveFilenames()
            ->acceptedFileTypes(['video/mp4', 'video/avi', 'video/mov', 'video/mkv'])
            ->directory($directory);
    }
    public static function iconFileUpload($directory)
    {
        return Repeater::make('icon')->label('Icon')->schema([
            FileUpload::make('path')
                ->image()
                ->label('Icon')

                ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml', 'image/webp'])
                ->preserveFilenames()
                ->imageEditorAspectRatios([
                    '1:1',
                ])
                ->directory($directory),
            TextInput::make('alt')->label('Alt'),
        ])->addable(false)->reorderable(false)->deletable(false);
    }

    public static function serviceCardRepeater()
    {
        return Repeater::make('service_card')
            ->label('Service Card')
            ->schema([
                TextInput::make('title')->label('Title')->required(),
                Textarea::make('description')
                    ->label('Description')->required(),
                FileUpload::make('image')
                    ->image()
                    ->label('Image')

                    ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml', 'image/webp'])
                    ->imageEditor()
                    ->preserveFilenames()
                    ->directory('services/card')
                    ->imageEditorAspectRatios([
                        '1:1',
                    ]),
            ])
            ->columns(3);
    }
    public static function actionsRepeater()
    {
        return Repeater::make('actions')
            ->label('Actions')
            ->schema([
                TextInput::make('title')->label('Title')->required(),
                Textarea::make('description')
                    ->label('Description'),
                TextInput::make('label')->label('Label')->required(),
                TextInput::make('link')->label('Link')->required(),
                FileUpload::make('image')
                    ->image()
                    ->label('Image')

                    ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml', 'image/webp'])
                    ->imageEditor()
                    ->preserveFilenames()
                    ->directory('services/actions')
                // ->imageEditorAspectRatios([
                //     '16:9',
                // ]),
            ])
            ->columns(2);
    }

    public static function staticCardRepeater()
    {
        return Repeater::make('static_card')
            ->label('Static Card')
            ->schema([
                TextInput::make('title')->label('Title')->required(),
                TextInput::make('subtitle')->label('Subtitle'),
                Textarea::make('description')
                    ->label('Description')->required(),
                FileUpload::make('icon')
                    ->image()
                    ->label('Icon')

                    ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml', 'image/webp'])
                    ->imageEditor()
                    ->preserveFilenames()
                    ->directory('services/static-card')
                    ->imageEditorAspectRatios([
                        '1:1',
                    ]),
                TextInput::make('alt')->label('Alt'),

            ])
            ->columns(2);
    }

    public static function challengesRepeater()
    {
        return Repeater::make('challenges')
            ->label('Challenges')
            ->schema([
                TextInput::make('title')->label('Title')->required(),
                Textarea::make('description')
                    ->label('Description')->required(),

            ])
            ->columns(2);
    }
    public static function systemTitleTextInput()
    {
        return TextInput::make('system_title')->label('Title');
    }
    public static function systemDescriptionTextarea()
    {
        return Textarea::make('system_description')->label('Description');
    }

    public static function systemDesktopFileUpload()
    {
        return  Repeater::make('system_desktop')->label('Desktop')->schema([
            FileUpload::make('image')
                ->image()
                ->label('Image')

                ->imageEditor()
                ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml', 'image/webp'])
                ->directory('system/desktop')
                ->preserveFilenames()
                ->label('Desktop'),
            TextInput::make('alt')->label('Alt'),
        ])->reorderable()->maxItems(6);
    }

    public static function systemMobileFileupload()
    {
        return  Repeater::make('system_mobile')->label('Mobile')->schema([
            FileUpload::make('image')
                ->image()
                ->label('Image')

                ->imageEditor()
                ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml', 'image/webp'])
                ->directory('system/desktop')
                ->preserveFilenames()
                ->label('Mobile'),
            TextInput::make('alt')->label('Alt'),
        ])->reorderable()->maxItems(6);
    }
    public static function colorRepeater()
    {
        return Repeater::make('colors')
            ->label('Colors')
            ->schema([
                ColorPicker::make('value')->label('Value')->required(),
            ]);
    }
    public static function colorschemeImageFileUpload($directory)
    {
        return Repeater::make('colorscheme')->label('Colorscheme')->schema([
            FileUpload::make('image')
                ->image()
                ->label('Image')

                ->imageEditor()
                ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml', 'image/webp'])
                ->preserveFilenames()
                ->directory($directory),
            TextInput::make('alt')->label('Alt'),
        ])->addable(true)->maxItems(3)->reorderable();
    }
    //typography
    public static function typographyImageFileUpload($directory)
    {
        return Repeater::make('typography')->label('Typography')->schema([
            FileUpload::make('image')
                ->label('Image')
                ->image()
                ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml', 'image/webp'])
                ->imageEditor()
                ->preserveFilenames()
                ->directory($directory),
            TextInput::make('alt')->label('Alt'),
        ])->addable(true)->maxItems(3)->reorderable()->columns(2);
    }
    public static function websiteTextInput()
    {
        return TextInput::make('website')->label('Website');
    }

    public static function callToActionRepeater()
    {
        return Repeater::make('call_to_action')->schema([
            TextInput::make('title')->label('Title'),
            Textarea::make('description')->label('Description'),
            FileUpload::make('image')->label('Image')->image()->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml', 'image/webp']),
            TextInput::make('alt')->label('Alt'),
            TextInput::make('link')->label('Link'),
            TextInput::make('label')->label('Button Label'),
        ])->label('Call to Action')->reorderable(false)->addable(false)->deletable(false)->columns(2);
    }
    public static function approachesRepeater()
    {
        return Repeater::make('approaches')->schema([
            TextInput::make('title')->label('Title'),
            Textarea::make('description')->label('Description'),
            FileUpload::make('image')->image()->directory('projects/approaches')->label('Image')->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml', 'image/webp'])->preserveFilenames(),
            TextInput::make('alt')->label('Alt'),
        ])->label('Approaches')->reorderable(true)->addable(true)->deletable(true)->maxItems(2)->columns(2);
    }

    public static function questionInput()
    {
        return TextInput::make('question')->label('Question')->required();
    }

    public static function answerTextarea()
    {
        return Textarea::make('answer')->label('Answer')->required();
    }

    public static function logoImageUpload($directory)
    {
        return FileUpload::make('logo')
            ->image()
            ->directory($directory)
            ->label('Logo')

            ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml', 'image/webp'])
            ->imageEditor()
            ->preserveFilenames();
    }
    public static function logoAltTextInput()
    {
        return TextInput::make('logo_alt')->label('Logo Alt');
    }
    public static function siteNameInput()
    {
        return TextInput::make('name')->label('Name')->required();
    }
    public static function faviconUpload($directory)
    {
        return FileUpload::make('favicon')
            ->image()
            ->directory($directory)
            ->label('Favicon')

            ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml', 'image/webp'])
            ->imageEditor()
            ->preserveFilenames();
    }
    public static function siteDescriptionTextarea()
    {
        return Textarea::make('description')->label('Description');
    }
    public static function siteSocialRepeater()
    {
        return Repeater::make('social')->label('Social')->schema([
            TextInput::make('name')->label('Name')->default(''),
            TextInput::make('icon')->label('Icon')->default(''),
            TextInput::make('link')->label('Link')->default(''),
        ])->reorderable()->maxItems(6)->columns(3);
    }



    public static function siteContactRepeater()
    {
        return Repeater::make('contact')->label('Contact')->schema([
            TextInput::make('address')->label('Address')->default(''),
            TextInput::make('phone')->label('Phone')->default(''),
            TextInput::make('mail')->label('Mail')->default(''),
            Textarea::make('map')->label('Map')->default(''),
        ])->addable(false);
    }

    public static function siteFooterRepeater()
    {
        return Repeater::make('footer')->label('Footer')->schema([
            TextInput::make('name')->label('Name')->default(''),
            Repeater::make('items')->schema([
                TextInput::make('label')->label('Label')->default(''),
                TextInput::make('link')->label('Link')->default(''),
            ])->maxItems(5)->reorderable()->label('Items')->columns(2),
        ])->reorderable()->maxItems(4)->columns(2);
    }

    public static function siteCopyrightRepeater()
    {
        return Repeater::make('copyright')->label('Copyright')->schema([
            TextInput::make('name')->label('Name')->default(''),
            TextInput::make('link')->label('Link')->default(''),
        ])->reorderable()->maxItems(2)->columns(2);
    }
}

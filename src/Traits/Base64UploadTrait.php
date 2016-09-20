<?php namespace HomeBargain\LaravelRepo\Traits;

use Eventviva\ImageResize;

trait Base64UploadTrait {

    /**
     * Loop through the data passed as a parameter identifying an base64 encoded assets and upload the AWS amending
     * input array with details of newly uploaded assets.
     * 
     * @param  array  $input
     * @return array
     */
    public function formatBase64Uploads( array $input )
    {
        $formattedInput = [];
        $assetKey = null;

        // We need to loop through and see if there are any assets to be uploaded.
        // Signified by a key ending in "_base64"
        foreach( $input as $key => $value )
        {
            if( $this->endsWith( $key, "_base64" ) || $this->endsWith( $key, "_mimetype" ) )
            {
                if( $this->endsWith( $key, "_base64" ) )
                {
                    // We have a base64 encoded asset field. Upload the asset and store the location
                    // in a class property of the same name without the trailing "_asset" for example
                    // if the key is called "image_url_base64" the location of the uploaded asset will
                    // be stored in "image_url".
                    $assetKey = substr( $key, 0, strlen( $key ) - 7 );

                    // Upload
                    $formattedInput[$assetKey] = $this->uploadBase64( $key, $input );

                    // Store the mimetype
                    $formattedInput[$assetKey.'_mimetype'] = \Storage::mimeType( $this->getModelName().'/'.$this->getModel()->id.'/'.$formattedInput[$assetKey] );
                }
            }
            elseif( isSet( $input[$key.'_base64'] ) === false )
            {
                $formattedInput[$key] = $value;
            }
        }

        return $formattedInput;
    }

    /**
     * Compare the string given as a needle to the last characters in the haystack.
     * 
     * @param  string $haystack
     * @param  string $needle
     * 
     * @return boolean
     */
    public function endsWith( $haystack, $needle ) 
    {
        return $needle === "" || ( ( $temp = strlen( $haystack ) - strlen( $needle ) ) >= 0 && strpos( $haystack, $needle, $temp ) !== false );
    }

    /**
     * Return a random string
     * 
     * @return string
     */
    public function hashUp()
    {
      return hash('md5', time() + rand(1,10000) );
    }

    /**
     * Return the name of the file without it's extension for example "myPicture.png" will return "myPicture"
     * 
     * @param  string $fileName
     * 
     * @return string
     */
    public function getBaseName( $fileName )
    {
        $info = new \SplFileInfo( $fileName );
        return $info->getBasename('.'.$info->getExtension());
    }

    /**
     * Return the file extension of the file name passed as a parameter.
     * 
     * @param  string $file_name
     * 
     * @return string
     */
    public function getFileExtension( $fileName )
    {
      $info = new \SplFileInfo( $fileName );
      return $info->getExtension();
    }

    /**
     * Upload the base64 encoded file to S3 storage.
     *
     * @param  $uploadKey     Name of the array element containing base64 encoded data.
     * @param  $input          Input array posted/put by the user
     * 
     * @return  string
     */
    public function uploadBase64( $uploadKey, array $input )
    {
        // The location/url of the uploaded asset will be stored in a property of the same name
        // without the trailing "_asset".
        $assetKey = substr( $uploadKey, 0, strlen($uploadKey) - 7 );
        
        if( $this->getModel()->id )
        {
            // Delete any existing assets
            \Storage::deleteDirectory( $this->getModelName().'/'.$this->getModel()->id );

            $fileName = $input[$uploadKey]['filename'];

            // Move the asset to a permanent folder
            \Storage::put( $this->getModelName().'/'.$this->getModel()->id.'/'.$fileName, base64_decode( $input[$uploadKey]['base64'] ) );

            // If we have uploaded an image we may need to resize
            if( $this->isImage( \Storage::mimeType( $this->getModelName().'/'.$this->getModel()->id.'/'.$fileName ) ) )
            {
                $this->resizeImage( $uploadKey, $input );
            }
        }
        else
        {
            // Create a unique file name using a hash of the current unix timestamp.
            $uniqueHash = $this->hashUp();
            $fileName = $this->getBaseName( $input[$uploadKey]['filename'] ).'-'.$uniqueHash.".".$this->getFileExtension( $input[$uploadKey]['filename'] );
            // Move the asset to a permanent folder
            \Storage::put( $this->getModelName().'/'.$fileName, base64_decode( $input[$uploadKey]['base64'] ) );

        }

        // Return the name of the asset
        return $fileName;
    }

    /**
     * Determine if the current file is an image
     * 
     * @param  string       path to the file 
     * @return boolean
     */
    public function isImage( $mimeType )
    {
        return substr( $mimeType, 0, 5 ) == 'image' ? true : false;
    }

    /**
     * Will move a file in S3.
     *
     * @param  string  Source location of the file
     * @param  string  Target location of the file.
     * 
     * @return boolean
     */
    public function moveFile( $source, $destination )
    {
        return \Storage::move( $source, $destination );
    }

    /** 
     * Resize the image and place in subfolders according to the class property $resizeImage
     */
    public function resizeImage( $uploadKey, array $input )
    {
        foreach( $this->imageResize as $folder => $height )
        {
            $image = ImageResize::createFromString( base64_decode( $input[$uploadKey]['base64'] ) );    
            $image->scale($height);
            \Storage::put( $this->getModelName().'/'.$this->getModel()->id.'/'.$folder.'/'.$input[$uploadKey]['filename'], $image->getImageAsString() );
        }
    }
}
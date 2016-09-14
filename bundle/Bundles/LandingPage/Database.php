<?php

namespace EzSystems\EzStudioUpgradeBundle\Bundles\LandingPage;

use eZ\Publish\API\Repository\ContentTypeService;
use eZ\Publish\Core\Base\Exceptions\NotFound\FieldTypeNotFoundException;
use eZ\Publish\Core\Persistence\Database\DatabaseHandler;
use eZ\Publish\Core\Persistence\Legacy\Exception\TypeNotFound;
use EzSystems\EzStudioUpgrade\SPI\Installer;
use Symfony\Component\Console\Output\ConsoleOutput;

class Database implements Installer
{
    protected $handler;

    protected $contentTypeService;

    public function __construct(DatabaseHandler $handler, ContentTypeService $contentTypeService)
    {
        $this->handler = $handler;
        $this->contentTypeService = $contentTypeService;
    }

    public function precondition()
    {
        $output = new ConsoleOutput();
        $output->write(sprintf(' [?] check database for required "landing_page" ContentType... '));

        try {
            $this->contentTypeService->loadContentTypeByIdentifier('landing_page');

            $output->writeln('found.');
            return true;
        }
        catch(TypeNotFound $e) {
            $output->writeln('not found.');
            return false;
        }
        catch(FieldTypeNotFoundException $e) {
            $output->writeln('not found.');
            return false;
        }
    }

    public function install()
    {
        $output = new ConsoleOutput();
        $output->write(' [+] add new "landing_page" ContentType... ');

        $this->handler->exec('INSERT INTO `ezcontentclass` (`always_available`, `contentobject_name`, `created`, `creator_id`, `identifier`, `initial_language_id`, `is_container`, `language_mask`, `modified`, `modifier_id`, `remote_id`, `serialized_description_list`, `serialized_name_list`, `sort_field`, `sort_order`, `url_alias_name`, `version`) VALUES (1,\'<name>\',1435924826,14,\'landing_page\',2,1,2,1435924826,14,\'60c03e9758465eb69d56b3afb6adf18e\',\'a:1:{s:6:\"eng-GB\";s:0:\"\";}\',\'a:1:{s:6:\"eng-GB\";s:12:\"Landing page\";}\',2,0,\'\',0);');

        $contentTypeId = $this->handler->lastInsertId();

        $this->handler->exec(sprintf('INSERT INTO `ezcontentclass_attribute` (`can_translate`, `category`, `contentclass_id`, `data_float1`, `data_float2`, `data_float3`, `data_float4`, `data_int1`, `data_int2`, `data_int3`, `data_int4`, `data_text1`, `data_text2`, `data_text3`, `data_text4`, `data_text5`, `data_type_string`, `identifier`, `is_information_collector`, `is_required`, `is_searchable`, `placement`, `serialized_data_text`, `serialized_description_list`, `serialized_name_list`, `version`) VALUES (1,\'content\',%d,NULL,NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,\'ezstring\',\'name\',0,1,1,10,\'N;\',\'a:1:{s:6:\"eng-GB\";s:5:\"Title\";}\',\'a:1:{s:6:\"eng-GB\";s:5:\"Title\";}\',0);',
            $contentTypeId
        ));
        $this->handler->exec(sprintf('INSERT INTO `ezcontentclass_attribute` (`can_translate`, `category`, `contentclass_id`, `data_float1`, `data_float2`, `data_float3`, `data_float4`, `data_int1`, `data_int2`, `data_int3`, `data_int4`, `data_text1`, `data_text2`, `data_text3`, `data_text4`, `data_text5`, `data_type_string`, `identifier`, `is_information_collector`, `is_required`, `is_searchable`, `placement`, `serialized_data_text`, `serialized_description_list`, `serialized_name_list`, `version`) VALUES (1,\'content\',%d,NULL,NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,\'ezstring\',\'description\',0,1,1,20,\'N;\',\'a:1:{s:6:\"eng-GB\";s:24:\"Landing page description\";}\',\'a:1:{s:6:\"eng-GB\";s:11:\"Description\";}\',0);',
            $contentTypeId
        ));
        $this->handler->exec(sprintf('INSERT INTO `ezcontentclass_attribute` (`can_translate`, `category`, `contentclass_id`, `data_float1`, `data_float2`, `data_float3`, `data_float4`, `data_int1`, `data_int2`, `data_int3`, `data_int4`, `data_text1`, `data_text2`, `data_text3`, `data_text4`, `data_text5`, `data_type_string`, `identifier`, `is_information_collector`, `is_required`, `is_searchable`, `placement`, `serialized_data_text`, `serialized_description_list`, `serialized_name_list`, `version`) VALUES (0,\'content\',%d,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,\'ezlandingpage\',\'page\',0,0,0,30,\'N;\',\'a:1:{s:6:\"eng-GB\";s:12:\"Landing page\";}\',\'a:1:{s:6:\"eng-GB\";s:12:\"Landing page\";}\',0);',
            $contentTypeId
        ));
        $this->handler->exec(sprintf('INSERT INTO `ezcontentclass_classgroup` VALUES (%d,0,1,\'Content\');',
            $contentTypeId
        ));
        $this->handler->exec(sprintf('INSERT INTO `ezcontentclass_name` VALUES (%d,0,2,\'eng-GB\',\'Landing page\');',
            $contentTypeId
        ));

        $output->writeln('done.');
    }
}

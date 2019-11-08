<?php /** @noinspection HtmlUnknownAttribute */
declare(strict_types=1);

namespace App\Tests\functional\Downloader;

use App\Downloader\FeedDownloader;
use App\Tests\FunctionalTester;
use App\ValueObject\FeedEntry;
use SimpleXMLElement;

class FeedDownloaderCest
{

    public function testGetFeedInfo(FunctionalTester $I)
    {
        $feedLink   = codecept_data_dir('feedExample.xml');
        $testObject = new FeedDownloader($feedLink);

        $I->assertSame('tag:theregister.co.uk,2005:feed/theregister.co.uk/software/', (string)$testObject->getFeedInfo()->id);
        $I->assertSame('https://www.theregister.co.uk/Design/graphics/Reg_default/The_Register_r.png', (string)$testObject->getFeedInfo()->logo);
    }

    public function testGetFeedEntries(FunctionalTester $I)
    {

        $feedLink   = codecept_data_dir('feedExample.xml');
        $testObject = new FeedDownloader($feedLink);

        $entries = $testObject->getFeedEntries();

        $I->assertCount(3, $entries);

        $feedEntry = new FeedEntry(new SimpleXMLElement(<<<XML
    <entry>
        <id>tag:theregister.co.uk,2005:story205664</id>
        <updated>2019-11-06T17:42:05Z</updated>
        <author>
            <name>Tim Anderson</name>
            <uri>https://search.theregister.co.uk/?author=Tim%20Anderson</uri>
        </author>
        <link rel="alternate" type="text/html" href="https://go.theregister.co.uk/feed/www.theregister.co.uk/2019/11/06/google_adds_virtual_desktops_to_chrome_os/"/>
        <title type="html">Chrome OS: Yo dawg, I heard you like desktops so we put a workspace in your workspace</title>
        <summary type="html" xml:base="https://www.theregister.co.uk/">&lt;h4&gt;So you can work on something while you work on something&lt;/h4&gt; &lt;p&gt;Google has added virtual desktops to its Chrome OS, used in Chromebooks, enabling users to create multiple workspaces and switch between them.â€¦&lt;/p&gt;</summary>
    </entry>
XML));
        $I->assertEquals(
            $feedEntry,
            $entries[0]
        );

        $feedEntry = new FeedEntry(new SimpleXMLElement(<<<XML
    <entry>
        <id>tag:theregister.co.uk,2005:story205655</id>
        <updated>2019-11-06T08:09:07Z</updated>
        <author>
            <name>Thomas Claburn</name>
            <uri>https://search.theregister.co.uk/?author=Thomas%20Claburn</uri>
        </author>
        <link rel="alternate" type="text/html" href="https://go.theregister.co.uk/feed/www.theregister.co.uk/2019/11/06/npm_fund/"/>
        <title type="html">NPM today stands for Now Pay Me: JavaScript packaging biz debuts conduit for funding open-source coders</title>
        <summary type="html" xml:base="https://www.theregister.co.uk/">&lt;h4&gt;Like a particular module? You're one command away from being able to donate some dosh for it&lt;/h4&gt; &lt;p&gt;NPM Inc, maintainer of the widely used JavaScript package manager npm, has taken a step toward fulfilling a promise made in August to help open-source developers seek compensation for their labor.â€¦&lt;/p&gt;</summary>
    </entry>
XML));
        $I->assertEquals(
            $feedEntry,
            $entries[2]
        );
    }
}

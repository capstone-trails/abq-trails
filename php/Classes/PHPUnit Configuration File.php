<phpunit>
	<testsuites>
		<testsuite name="Photo abq-trails">
			<file>ProfileTest.php</file>
			<file>TweetTest.php</file>
			<file>FavoriteTest.php</file>
		</testsuite>
	</testsuites>
	<filter>
		<whitelist processUncoveredFilesFromWhitelist="true">
			<directory suffix=".php">..</directory>
		</whitelist>
	</filter>
</phpunit>
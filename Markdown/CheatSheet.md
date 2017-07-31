# Markdown
## Headers (up to 6 levels)
    Level1     or     # Level1       -->    <h1>Level1</h1>
    ======
    Level2     or     ## Level2      -->    <h2>Level2</h2>
    ------
    ...
    N/A               ###### Level6  -->    <h6>Level6</h6>
## Paragraph & line breaks
    Empty line                       -->    <p />
    Two spaces at the line end       -->    <br />
## Emphasis
    **Bold**   or     __Bold__       -->    <strong>Bold</strong>
    *Italic*   or     _Italic_       -->    <em>Italic</em>
    **Bo*Italic*ld**                 -->    <strong>Bo<em>Italic</em>ld</strong>
    \*Regular\*, \_Regular\_         -->    *Regular*, _Regular_
## Code
    `var x = 4;`                     -->   <code>var x = 4;</code>
    `<div>`                          -->   <code>&lt;div&gt;</code>
    `&mdash;`                        -->   <code>&amp;mdash;</code>
    ``Escape backtick (`)``          -->   <code>Escape backtick (`)</code>
    Four spaces at the line begin    -->   <pre><code>Multiline</code></pre>
## Blockquotes
    > Text1                          -->   <blockquote>Text1<p />Text2</blockquote>
    >
    > Text2
## Horizontal rules
    ---, - - -, ***, * * *, ___      -->   <hr />
## Lists
    *,  +,  -                        -->   <ul><li></li>
    *   +   -                                  <li></li>
    *   +   -                                  <li></li></ul>
    1.                               -->   <ol><li></li>
    2.                                         <li></li>
    42.                                        <li></li></ol>
    1\. Regular                      -->   1. Regular
## Links
    [Text](URL "Title")              -->   <a href="URL" title="Title">Text</a>
    [Text][Id]                       -->   <a href="URL" title="Title">Text</a>
    [Id]: URL "Title"
    [Text][]                         -->   <a href="URL" title="Title">Text</a>
    [Text]: URL "Title"
    <URL|Email>                      -->   <a href="URL">URL|(encoded)Email</a>
## Images
    ![AltText](Path "Title")         -->   <img src="Path" alt="AltText" title="Title" />
    ![AltText][Id]                   -->   <img src="Path" alt="AltText" title="Title" />
    [Id]: Path "Title"
*Markdown has no syntax for specifying the dimensions of an image*
## Backslash escapes
    \   backslash
    `   backtick
    *   asterisk
    _   underscore
    {}  curly braces
    []  square brackets
    ()  parentheses
    #   hash mark
    +   plus sign
    -   minus sign (hyphen)
    .   dot
    !   exclamation mark
## GitHub Flavored Markdown
### Syntax highlighting
    ```javascript
    function fancyAlert(arg) {
      if(arg) {
        $.facebox({div:'#foo'})
      }
    }
    ```
*You can add an optional language identifier to enable syntax highlighting in your fenced code block*
* [Linguist YAML file (language IDs)](https://github.com/github/linguist/blob/master/lib/linguist/languages.yml "linguist/languages.yml at master · github/linguist · GitHub")
### Task Lists
    - [x] @mentions, #refs, [links](), **formatting**, and <del>tags</del> supported
    - [x] \(Optional) list syntax required (any unordered or ordered list supported)
    - [x] this is a complete item
    - [ ] this is an incomplete item
*If you include a task list in the first comment of an Issue, you will get a handy progress indicator in your issue list. It also works in Pull Requests*  
*If a task list item description begins with a parenthesis, you'll need to escape it with `\`*
### Tables
    First Header | Second Header
    ------------ | -------------
    Content from cell 1 | Content from cell 2
    Content in the first column | Content in the second column
*There must be at least three hyphens in each column of the header row*  
*The outer pipes (`|`) are optional, and you don't need to make the raw Markdown line up prettily*  
*You can use formatting such as links, inline code blocks, and text styling within your table*

     Left-aligned | Center-aligned | Right-aligned
     :---         |     :---:      |          ---: 
     git status   | git status     | git status    
     git diff     | git diff       | \|            
*To include a pipe `|` as content within your cell, use a `\` before the pipe*
### SHA references
    16c999e8c71134401a78d4d46435517b2271d6ac
    mojombo@16c999e8c71134401a78d4d46435517b2271d6ac
    mojombo/github-flavored-markdown@16c999e8c71134401a78d4d46435517b2271d6ac
*Any reference to a commit’s SHA-1 hash will be automatically converted into a link to that commit on GitHub*
### Issue references within a repository
    #1
    mojombo#1
    mojombo/github-flavored-markdown#1
*Any number that refers to an Issue or Pull Request will be automatically converted into a link*
### Username @mentions
    @vadim-vj Test
    @organization/team-name Test
    @github/support What do you think about these updates?
*Typing an `@` symbol, followed by a username, will notify that person to come and view the comment. You can also @mention teams within an organization*
### Automatic linking for URLs
*Any URL (like `http://www.github.com/`) will be automatically converted into a clickable link.*
### Strikethrough
*Any word wrapped with two tildes (like `~~this~~`) will appear crossed out*
### Relative link URLs & image paths
*The same as regular links and images. `./` and `../` are allowed*
### Emoji
    @octocat :+1: This PR looks great - it's ready to merge! :shipit:
* [Emoji Cheat Sheet](https://www.webpagefx.com/tools/emoji-cheat-sheet "Using emoji")

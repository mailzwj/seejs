/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 60004
Source Host           : localhost:3306
Source Database       : seejs

Target Server Type    : MYSQL
Target Server Version : 60004
File Encoding         : 65001

Date: 2015-11-08 11:50:45
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `sourcecontent` text,
  `content` text,
  `publisher` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `praise` int(10) DEFAULT '0',
  `comment` int(10) DEFAULT '0',
  `deleted` int(2) DEFAULT '0',
  `published` int(2) DEFAULT '0',
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES ('15', 'ZeroClipboard的时代或许已经过去了', '曾经，一个网页上要用Javascript实现网页内容的复制，其实是很麻烦的一件事情。虽然在这个问题上IE有其高大上的`window.clipboardData`方法支持直接复制指定内容，Firefox也早早的支持了`document.execCommand`命令，但是因为早期的Chrome不支持浏览器直接操作剪贴板，或者说不支持`document.execCommand`命令，让这一功能在兼容性上遇到了瓶颈。所以，聪明的开发者们开始走上“曲线救国”的道路：借助各大浏览器对Flash的支持，通过Javascript与Flash交互，将需要复制的内容传递到Flash中，再调用Flash操作剪切板的命令将内容复制到剪贴板，从而实现了兼容性极强的通过JS脚本复制网页文本的插件。这也就是[ZeroClipboard](http://zeroclipboard.org/ \'ZeroClipboard\')的使命。\r\n\r\n&gt; The ZeroClipboard library provides an easy way to copy text to the clipboard using an invisible Adobe Flash movie and a JavaScript interface.\r\n\r\nZeroClipboard曾盛极一时，而如今它的未来，恐怕令人担忧。随着HTML5的风靡，Flash在网页应用中的地位受到了极大的冲击，甚至有很多人都认为Flash正在慢慢淡出网页开发者的世界，而事实也的确如此。不仅如此，自Chrome 43版本发布，增加`document.execCommand`命令支持，更让ZeroClipboard的地位严重受到威胁。为什么这么说呢？下面我们一步一步来说明。\r\n\r\n#### ZeroClipboard使用案例\r\n\r\n通常情况下，ZeroClipord的应用场景大致是通过点击一个按钮复制一段指定的或用户输入的文本，HTML结构简单的做如下描述：\r\n\r\n```xml\r\n&lt;input type=&quot;text&quot; name=&quot;&quot; id=&quot;J_TextIn&quot; value=&quot;Copy Test.&quot;&gt;\r\n&lt;input type=&quot;button&quot; value=&quot;Copy&quot; id=&quot;J_DoCopy&quot;&gt;\r\n&lt;script src=&quot;dist/ZeroClipboard.min.js&quot;&gt;&lt;/script&gt;\r\n```\r\n\r\n下面配上ZeroClipboard的方法绑定就大功告成了！\r\n\r\n```javascript\r\n(function(){\r\n    var btn = document.getElementById(\'J_DoCopy\'),\r\n        text = document.getElementById(\'J_TextIn\'),\r\n        zc = new ZeroClipboard(btn);\r\n    zc.on(\'beforecopy\', function(e){\r\n        zc.setText(text.value);\r\n    });\r\n})();\r\n```\r\n\r\n我们预览页面，在文本框中输入任意字符，点击`Copy`按钮，文本框中输入的内容就被复制到剪贴板中了。我们可以在任意可写区域使用`Ctrl+V`或鼠标右键将内容进行粘贴。该案例可完美兼容各主流浏览器，包括IE6/7/8等骨灰级浏览器。\r\n\r\n#### 现在不使用ZeroClipboard我们也能实现\r\n\r\n首先，我们保证页面结构不变，但不在引入ZeroClipboard插件：\r\n\r\n```xml\r\n&lt;input type=&quot;text&quot; name=&quot;&quot; id=&quot;J_TextIn&quot; value=&quot;Copy Test.&quot;&gt;\r\n&lt;input type=&quot;button&quot; value=&quot;Copy&quot; id=&quot;J_DoCopy&quot;&gt;\r\n```\r\n\r\n然后，我们使用`document.execCommamd`来对内容进行复制：\r\n\r\n```javascript\r\n(function(){\r\n    var btn = document.getElementById(\'J_DoCopy\'),\r\n        text = document.getElementById(\'J_TextIn\');\r\n    btn.onclick = function(){\r\n        var transfer = document.getElementById(\'J_CopyTransfer\');\r\n        if (!transfer) {\r\n            transfer = document.createElement(\'textarea\');\r\n            transfer.id = \'J_CopyTransfer\';\r\n            transfer.style.position = \'absolute\';\r\n            transfer.style.left = \'-9999px\';\r\n            transfer.style.top = \'-9999px\';\r\n            document.body.appendChild(transfer);\r\n        }\r\n        transfer.value = text.value;\r\n        transfer.focus();\r\n        transfer.select();\r\n        document.execCommand(\'Copy\', false, null);\r\n    };\r\n})();\r\n```\r\n\r\n接着，我们在浏览器中浏览，和使用ZeroClipboard时一样的去操作，效果是一样的。但是，这段代码的正确执行是有限制的，因为`document.execCommand`在Chrome中支持的比较晚，所以要求Chrome版本必须是43及以后。\r\n\r\n最后，再补充说明一下，使用`document.execCommand`来实现复制内容时，过渡被复制内容的`textarea`标签（即：动态创建的那个textarea标签），在复制可输入区域（input:text,textarea）的内容时并不是必须的，可以直接简化为：\r\n\r\n```javascript\r\n(function(){\r\n    var btn = document.getElementById(\'J_DoCopy\'),\r\n        text = document.getElementById(\'J_TextIn\');\r\n    btn.onclick = function(){\r\n        text.focus();\r\n        text.select();\r\n        document.execCommand(\'Copy\', false, null);\r\n        text.blur();\r\n    };\r\n})();\r\n```\r\n\r\n考虑到实际使用中，我们可能需要复制一些非编辑区域提供的内容（比如：一个a标签的链接地址等），所以增加了一个过渡的texearea，似乎更保险，更灵活一些。\r\n\r\n此外，我再测试过程中，曾试图将过渡的那个textarea设置为不可见的`visibility:hidden;`，却发现复制功能失效了，所以这里需要注意一下...', '<p>曾经，一个网页上要用Javascript实现网页内容的复制，其实是很麻烦的一件事情。虽然在这个问题上IE有其高大上的<code>window.clipboardData</code>方法支持直接复制指定内容，Firefox也早早的支持了<code>document.execCommand</code>命令，但是因为早期的Chrome不支持浏览器直接操作剪贴板，或者说不支持<code>document.execCommand</code>命令，让这一功能在兼容性上遇到了瓶颈。所以，聪明的开发者们开始走上“曲线救国”的道路：借助各大浏览器对Flash的支持，通过Javascript与Flash交互，将需要复制的内容传递到Flash中，再调用Flash操作剪切板的命令将内容复制到剪贴板，从而实现了兼容性极强的通过JS脚本复制网页文本的插件。这也就是<a href=&quot;http://zeroclipboard.org/&quot; title=&quot;ZeroClipboard&quot;>ZeroClipboard</a>的使命。</p>\r\n<blockquote>\r\n<p>The ZeroClipboard library provides an easy way to copy text to the clipboard using an invisible Adobe Flash movie and a JavaScript interface.</p>\r\n</blockquote>\r\n<p>ZeroClipboard曾盛极一时，而如今它的未来，恐怕令人担忧。随着HTML5的风靡，Flash在网页应用中的地位受到了极大的冲击，甚至有很多人都认为Flash正在慢慢淡出网页开发者的世界，而事实也的确如此。不仅如此，自Chrome 43版本发布，增加<code>document.execCommand</code>命令支持，更让ZeroClipboard的地位严重受到威胁。为什么这么说呢？下面我们一步一步来说明。</p>\r\n<h4 id=&quot;h4-zeroclipboard-&quot;><a name=&quot;ZeroClipboard使用案例&quot; class=&quot;reference-link&quot;></a><span class=&quot;header-link octicon octicon-link&quot;></span>ZeroClipboard使用案例</h4><p>通常情况下，ZeroClipord的应用场景大致是通过点击一个按钮复制一段指定的或用户输入的文本，HTML结构简单的做如下描述：</p>\r\n<pre><code class=&quot;lang-xml&quot;>&lt;input type=&quot;text&quot; name=&quot;&quot; id=&quot;J_TextIn&quot; value=&quot;Copy Test.&quot;&gt;\r\n&lt;input type=&quot;button&quot; value=&quot;Copy&quot; id=&quot;J_DoCopy&quot;&gt;\r\n&lt;script src=&quot;dist/ZeroClipboard.min.js&quot;&gt;&lt;/script&gt;\r\n</code></pre>\r\n<p>下面配上ZeroClipboard的方法绑定就大功告成了！</p>\r\n<pre><code class=&quot;lang-javascript&quot;>(function(){\r\n    var btn = document.getElementById(\'J_DoCopy\'),\r\n        text = document.getElementById(\'J_TextIn\'),\r\n        zc = new ZeroClipboard(btn);\r\n    zc.on(\'beforecopy\', function(e){\r\n        zc.setText(text.value);\r\n    });\r\n})();\r\n</code></pre>\r\n<p>我们预览页面，在文本框中输入任意字符，点击<code>Copy</code>按钮，文本框中输入的内容就被复制到剪贴板中了。我们可以在任意可写区域使用<code>Ctrl+V</code>或鼠标右键将内容进行粘贴。该案例可完美兼容各主流浏览器，包括IE6/7/8等骨灰级浏览器。</p>\r\n<h4 id=&quot;h4--zeroclipboard-&quot;><a name=&quot;现在不使用ZeroClipboard我们也能实现&quot; class=&quot;reference-link&quot;></a><span class=&quot;header-link octicon octicon-link&quot;></span>现在不使用ZeroClipboard我们也能实现</h4><p>首先，我们保证页面结构不变，但不在引入ZeroClipboard插件：</p>\r\n<pre><code class=&quot;lang-xml&quot;>&lt;input type=&quot;text&quot; name=&quot;&quot; id=&quot;J_TextIn&quot; value=&quot;Copy Test.&quot;&gt;\r\n&lt;input type=&quot;button&quot; value=&quot;Copy&quot; id=&quot;J_DoCopy&quot;&gt;\r\n</code></pre>\r\n<p>然后，我们使用<code>document.execCommamd</code>来对内容进行复制：</p>\r\n<pre><code class=&quot;lang-javascript&quot;>(function(){\r\n    var btn = document.getElementById(\'J_DoCopy\'),\r\n        text = document.getElementById(\'J_TextIn\');\r\n    btn.onclick = function(){\r\n        var transfer = document.getElementById(\'J_CopyTransfer\');\r\n        if (!transfer) {\r\n            transfer = document.createElement(\'textarea\');\r\n            transfer.id = \'J_CopyTransfer\';\r\n            transfer.style.position = \'absolute\';\r\n            transfer.style.left = \'-9999px\';\r\n            transfer.style.top = \'-9999px\';\r\n            document.body.appendChild(transfer);\r\n        }\r\n        transfer.value = text.value;\r\n        transfer.focus();\r\n        transfer.select();\r\n        document.execCommand(\'Copy\', false, null);\r\n    };\r\n})();\r\n</code></pre>\r\n<p>接着，我们在浏览器中浏览，和使用ZeroClipboard时一样的去操作，效果是一样的。但是，这段代码的正确执行是有限制的，因为<code>document.execCommand</code>在Chrome中支持的比较晚，所以要求Chrome版本必须是43及以后。</p>\r\n<p>最后，再补充说明一下，使用<code>document.execCommand</code>来实现复制内容时，过渡被复制内容的<code>textarea</code>标签（即：动态创建的那个textarea标签），在复制可输入区域（input:text,textarea）的内容时并不是必须的，可以直接简化为：</p>\r\n<pre><code class=&quot;lang-javascript&quot;>(function(){\r\n    var btn = document.getElementById(\'J_DoCopy\'),\r\n        text = document.getElementById(\'J_TextIn\');\r\n    btn.onclick = function(){\r\n        text.focus();\r\n        text.select();\r\n        document.execCommand(\'Copy\', false, null);\r\n        text.blur();\r\n    };\r\n})();\r\n</code></pre>\r\n<p>考虑到实际使用中，我们可能需要复制一些非编辑区域提供的内容（比如：一个a标签的链接地址等），所以增加了一个过渡的texearea，似乎更保险，更灵活一些。</p>\r\n<p>此外，我再测试过程中，曾试图将过渡的那个textarea设置为不可见的<code>visibility:hidden;</code>，却发现复制功能失效了，所以这里需要注意一下…</p>\r\n', 'seejs', 'Web前端', 'http://local.jd.com:808/seejs/content/upload/pict-1446427973.png', '2', '2', '0', '1', '2015-11-02 09:33:07');
INSERT INTO `article` VALUES ('16', '浅谈图片宽度自适应解决方案', '在网页设计中，随着响应式设计的到来，各种响应式设计方案层出不穷。对于图片响应式的问题也有很多前端开发人员在进行研究。比较好的图片响应式设想便是在不同的屏幕分辨率下使用不同实际尺寸的图片，而达到在高速网络环境中使用大或超大高清图片，在低速网络或需要替用户节省流量资源的环境中使用小而清晰的图片，保证用户无论在何种环境下都能有良好的浏览体验。然而这是一个庞大而具有挑战的工作，我这里不做这个讨论，因为我目前还没有这方面很好的实践。这里我是要跟大家讨论下同一张图片在不同宽度的显示区域中的显示问题。\r\n\r\n### 问题描述\r\n\r\n我们先来看下我想要描述的问题。首先我准备了三张宽度不同的图片，让他们垂直排列在页面中，除了去除图片本身在垂直方向上产生的间距，不做其他任何样式处理，这种情况我们通常在博文中经常看到，在写博文的时候经常用到，具体效果请看：[图片宽度自适应（1）](http://sandbox.runjs.cn/show/wxqdsnmx)。简单看下我们的页面结构：\r\n\r\n```xml\r\n&lt;img src=&quot;imgs/560x200.jpg&quot; alt=&quot;&quot;&gt;&lt;br&gt;\r\n&lt;img src=&quot;imgs/440x200.jpg&quot; alt=&quot;&quot;&gt;&lt;br&gt;\r\n&lt;img src=&quot;imgs/300x200.jpg&quot; alt=&quot;&quot;&gt;\r\n```\r\n\r\n为了方便查看效果，我们直接调整浏览器宽度来测试。测试效果如下gif图所示：\r\n\r\n![默认图片样式效果](http://www.seejs.com/wp-content/uploads/2015/10/default.gif)\r\n\r\n我们不难发现，在我们改变窗口可视区域的时候，图片宽度并不会随之变化，以至于在小屏幕中我们只能开到图片的一部分，这是很多人所不乐见的，因为这极有可能会导致重要信息丢失。那么这个问题如何解决？\r\n\r\n### 简单尝试\r\n\r\n为了保证信息显示完整，保证图片随可视区域宽度变化而宽度自适应，我直接给图片标签设置了宽度100%，具体效果请看：[图片宽度自适应（2）](http://sandbox.runjs.cn/show/enkmkdfb)。\r\n\r\n和示例一一样，我们还是手动改变可视区域宽度来观看图片的表现：\r\n\r\n![图片宽度百分之百](http://www.seejs.com/wp-content/uploads/2015/10/width.gif)\r\n\r\n现在看来图片是可以根据可视区域宽度自适应了，但是问题来了：首先，所有图片不论原始大小宽窄一律以可是区域宽度为标准了，齐刷刷的一刀切，毫无美感；其次，当较宽显示区域显示较窄图片时，图片出现严重失真，甚至失去识别度。好吧，窄屏的问题解决了，宽屏的问题有来了，不知道这是要闹哪样！但是问题出来了，我们总要想办法去解决啊，那怎么办呢？\r\n\r\n### 兵来将挡，水来土掩\r\n\r\n是问题，总有解决的办法，只是成本高低的问题。对于上面这个问题我思考了许久，刚开始我想使用`width: 100%;max-width: 图片宽度;`来处理，但是，我发现图片宽度并不统一，max-width需要针对每一个宽度去设置，那根本不可行，无疑是自找麻烦，因为实际应用中，我们完全无法预知用户将使用多大宽度的图片。所以似乎单从控制图片样式已经找不到什么解决办法了，但是我开始关注`width: 100%;`的问题。\r\n\r\n我们知道，在CSS中，宽度的百分比是是相对于父级容器宽度的。如果我们能有办法控制图片标签的父容器的宽度，那问题是不是就解决了呢？\r\n\r\n首先，为了让图片标签有可控的父元素，我们先对代码结构做一点点调整：\r\n\r\n```xml\r\n&lt;div class=&quot;img-wrap&quot;&gt;\r\n    &lt;img src=&quot;imgs/560x200.jpg&quot; alt=&quot;&quot;&gt;\r\n&lt;/div&gt;\r\n&lt;div class=&quot;img-wrap&quot;&gt;\r\n    &lt;img src=&quot;imgs/440x200.jpg&quot; alt=&quot;&quot;&gt;\r\n&lt;/div&gt;\r\n&lt;div class=&quot;img-wrap&quot;&gt;\r\n    &lt;img src=&quot;imgs/300x200.jpg&quot; alt=&quot;&quot;&gt;\r\n&lt;/div&gt;\r\n```\r\n\r\n好了，接下来就是如何控制img-wrap元素的宽度的问题了。我首先想到的是浮动（float），因为我们知道浮动元素的宽度是随内容变化的，所以我先给img-wrap设置了如下样式：\r\n\r\n```css\r\n.img-wrap {float: left;}\r\n```\r\n\r\n但是，问题又来了，浮动元素会破坏原有的布局，如果不做清除浮动处理，会导致后面的内容紧跟在浮动元素之后。所以为了保证不影响其他内容，我们还得在img-wrap外面加一个容器来控制浮动与否：\r\n\r\n```xml\r\n&lt;div class=&quot;row&quot;&gt;\r\n    &lt;div class=&quot;img-wrap&quot;&gt;\r\n        &lt;img src=&quot;imgs/560x200.jpg&quot; alt=&quot;&quot;&gt;\r\n    &lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;div class=&quot;row&quot;&gt;\r\n    &lt;div class=&quot;img-wrap&quot;&gt;\r\n        &lt;img src=&quot;imgs/440x200.jpg&quot; alt=&quot;&quot;&gt;\r\n    &lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;div class=&quot;row&quot;&gt;\r\n    &lt;div class=&quot;img-wrap&quot;&gt;\r\n        &lt;img src=&quot;imgs/300x200.jpg&quot; alt=&quot;&quot;&gt;\r\n    &lt;/div&gt;\r\n&lt;/div&gt;\r\n```\r\n\r\n好吧，现在我们在来看看，被折腾成什么样子了，[图片宽度自适应（3）](http://sandbox.runjs.cn/show/eknk80m9)：\r\n\r\n![图片宽度自适应](http://www.seejs.com/wp-content/uploads/2015/10/wrap.gif)\r\n\r\n哈哈，好像是我想要的效果了。但是，作为一个有点强迫症的开发者，虽然达到了我想要的效果，但加了那么多层嵌套标签，总让我感觉不舒服。于是，我继续折腾，终于我恍然大悟，`display: inline-block`的元素宽度也是随内容变化的，而且图片默认样式恰巧也表现为inline-block的效果，是否可以从这里下手呢？\r\n\r\n```xml\r\n&lt;div class=&quot;img-wrap&quot;&gt;\r\n    &lt;img src=&quot;imgs/560x200.jpg&quot; alt=&quot;&quot;&gt;\r\n&lt;/div&gt;\r\n&lt;div class=&quot;img-wrap&quot;&gt;\r\n    &lt;img src=&quot;imgs/440x200.jpg&quot; alt=&quot;&quot;&gt;\r\n&lt;/div&gt;\r\n&lt;div class=&quot;img-wrap&quot;&gt;\r\n    &lt;img src=&quot;imgs/300x200.jpg&quot; alt=&quot;&quot;&gt;\r\n&lt;/div&gt;\r\n```\r\n\r\n结构再度回归到只有一层嵌套，然而css样式却需要调整一下：\r\n\r\n```css\r\n.img-wrap {display: inline-block;}\r\n```\r\n\r\n当我，再次进行测试的时候，心情舒畅多了，你们感受下：[图片宽度自适应（4）](http://sandbox.runjs.cn/show/rf4xmo6m)。\r\n\r\n最后，补上完整的css代码：\r\n\r\n```css\r\n.img-wrap {\r\n    display: inline-block;\r\n}\r\n.img-wrap img {\r\n    width: 100%;\r\n    vertical-align: middle;\r\n}\r\n```\r\n\r\n作者博客：[百码山庄](http://www.seejs.com)', '<p>在网页设计中，随着响应式设计的到来，各种响应式设计方案层出不穷。对于图片响应式的问题也有很多前端开发人员在进行研究。比较好的图片响应式设想便是在不同的屏幕分辨率下使用不同实际尺寸的图片，而达到在高速网络环境中使用大或超大高清图片，在低速网络或需要替用户节省流量资源的环境中使用小而清晰的图片，保证用户无论在何种环境下都能有良好的浏览体验。然而这是一个庞大而具有挑战的工作，我这里不做这个讨论，因为我目前还没有这方面很好的实践。这里我是要跟大家讨论下同一张图片在不同宽度的显示区域中的显示问题。</p>\r\n<h3 id=&quot;h3-u95EEu9898u63CFu8FF0&quot;><a name=&quot;问题描述&quot; class=&quot;reference-link&quot;></a><span class=&quot;header-link octicon octicon-link&quot;></span>问题描述</h3><p>我们先来看下我想要描述的问题。首先我准备了三张宽度不同的图片，让他们垂直排列在页面中，除了去除图片本身在垂直方向上产生的间距，不做其他任何样式处理，这种情况我们通常在博文中经常看到，在写博文的时候经常用到，具体效果请看：<a href=&quot;http://sandbox.runjs.cn/show/wxqdsnmx&quot;>图片宽度自适应（1）</a>。简单看下我们的页面结构：</p>\r\n<pre><code class=&quot;lang-xml&quot;>&lt;img src=&quot;imgs/560x200.jpg&quot; alt=&quot;&quot;&gt;&lt;br&gt;\r\n&lt;img src=&quot;imgs/440x200.jpg&quot; alt=&quot;&quot;&gt;&lt;br&gt;\r\n&lt;img src=&quot;imgs/300x200.jpg&quot; alt=&quot;&quot;&gt;\r\n</code></pre>\r\n<p>为了方便查看效果，我们直接调整浏览器宽度来测试。测试效果如下gif图所示：</p>\r\n<p><img src=&quot;http://www.seejs.com/wp-content/uploads/2015/10/default.gif&quot; alt=&quot;默认图片样式效果&quot;>\r\n<p>我们不难发现，在我们改变窗口可视区域的时候，图片宽度并不会随之变化，以至于在小屏幕中我们只能开到图片的一部分，这是很多人所不乐见的，因为这极有可能会导致重要信息丢失。那么这个问题如何解决？</p>\r\n<h3 id=&quot;h3-u7B80u5355u5C1Du8BD5&quot;><a name=&quot;简单尝试&quot; class=&quot;reference-link&quot;></a><span class=&quot;header-link octicon octicon-link&quot;></span>简单尝试</h3><p>为了保证信息显示完整，保证图片随可视区域宽度变化而宽度自适应，我直接给图片标签设置了宽度100%，具体效果请看：<a href=&quot;http://sandbox.runjs.cn/show/enkmkdfb&quot;>图片宽度自适应（2）</a>。</p>\r\n<p>和示例一一样，我们还是手动改变可视区域宽度来观看图片的表现：</p>\r\n<p><img src=&quot;http://www.seejs.com/wp-content/uploads/2015/10/width.gif&quot; alt=&quot;图片宽度百分之百&quot;>\r\n<p>现在看来图片是可以根据可视区域宽度自适应了，但是问题来了：首先，所有图片不论原始大小宽窄一律以可是区域宽度为标准了，齐刷刷的一刀切，毫无美感；其次，当较宽显示区域显示较窄图片时，图片出现严重失真，甚至失去识别度。好吧，窄屏的问题解决了，宽屏的问题有来了，不知道这是要闹哪样！但是问题出来了，我们总要想办法去解决啊，那怎么办呢？</p>\r\n<h3 id=&quot;h3--&quot;><a name=&quot;兵来将挡，水来土掩&quot; class=&quot;reference-link&quot;></a><span class=&quot;header-link octicon octicon-link&quot;></span>兵来将挡，水来土掩</h3><p>是问题，总有解决的办法，只是成本高低的问题。对于上面这个问题我思考了许久，刚开始我想使用<code>width: 100%;max-width: 图片宽度;</code>来处理，但是，我发现图片宽度并不统一，max-width需要针对每一个宽度去设置，那根本不可行，无疑是自找麻烦，因为实际应用中，我们完全无法预知用户将使用多大宽度的图片。所以似乎单从控制图片样式已经找不到什么解决办法了，但是我开始关注<code>width: 100%;</code>的问题。</p>\r\n<p>我们知道，在CSS中，宽度的百分比是是相对于父级容器宽度的。如果我们能有办法控制图片标签的父容器的宽度，那问题是不是就解决了呢？</p>\r\n<p>首先，为了让图片标签有可控的父元素，我们先对代码结构做一点点调整：</p>\r\n<pre><code class=&quot;lang-xml&quot;>&lt;div class=&quot;img-wrap&quot;&gt;\r\n    &lt;img src=&quot;imgs/560x200.jpg&quot; alt=&quot;&quot;&gt;\r\n&lt;/div&gt;\r\n&lt;div class=&quot;img-wrap&quot;&gt;\r\n    &lt;img src=&quot;imgs/440x200.jpg&quot; alt=&quot;&quot;&gt;\r\n&lt;/div&gt;\r\n&lt;div class=&quot;img-wrap&quot;&gt;\r\n    &lt;img src=&quot;imgs/300x200.jpg&quot; alt=&quot;&quot;&gt;\r\n&lt;/div&gt;\r\n</code></pre>\r\n<p>好了，接下来就是如何控制img-wrap元素的宽度的问题了。我首先想到的是浮动（float），因为我们知道浮动元素的宽度是随内容变化的，所以我先给img-wrap设置了如下样式：</p>\r\n<pre><code class=&quot;lang-css&quot;>.img-wrap {float: left;}\r\n</code></pre>\r\n<p>但是，问题又来了，浮动元素会破坏原有的布局，如果不做清除浮动处理，会导致后面的内容紧跟在浮动元素之后。所以为了保证不影响其他内容，我们还得在img-wrap外面加一个容器来控制浮动与否：</p>\r\n<pre><code class=&quot;lang-xml&quot;>&lt;div class=&quot;row&quot;&gt;\r\n    &lt;div class=&quot;img-wrap&quot;&gt;\r\n        &lt;img src=&quot;imgs/560x200.jpg&quot; alt=&quot;&quot;&gt;\r\n    &lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;div class=&quot;row&quot;&gt;\r\n    &lt;div class=&quot;img-wrap&quot;&gt;\r\n        &lt;img src=&quot;imgs/440x200.jpg&quot; alt=&quot;&quot;&gt;\r\n    &lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;div class=&quot;row&quot;&gt;\r\n    &lt;div class=&quot;img-wrap&quot;&gt;\r\n        &lt;img src=&quot;imgs/300x200.jpg&quot; alt=&quot;&quot;&gt;\r\n    &lt;/div&gt;\r\n&lt;/div&gt;\r\n</code></pre>\r\n<p>好吧，现在我们在来看看，被折腾成什么样子了，<a href=&quot;http://sandbox.runjs.cn/show/eknk80m9&quot;>图片宽度自适应（3）</a>：</p>\r\n<p><img src=&quot;http://www.seejs.com/wp-content/uploads/2015/10/wrap.gif&quot; alt=&quot;图片宽度自适应&quot;>\r\n<p>哈哈，好像是我想要的效果了。但是，作为一个有点强迫症的开发者，虽然达到了我想要的效果，但加了那么多层嵌套标签，总让我感觉不舒服。于是，我继续折腾，终于我恍然大悟，<code>display: inline-block</code>的元素宽度也是随内容变化的，而且图片默认样式恰巧也表现为inline-block的效果，是否可以从这里下手呢？</p>\r\n<pre><code class=&quot;lang-xml&quot;>&lt;div class=&quot;img-wrap&quot;&gt;\r\n    &lt;img src=&quot;imgs/560x200.jpg&quot; alt=&quot;&quot;&gt;\r\n&lt;/div&gt;\r\n&lt;div class=&quot;img-wrap&quot;&gt;\r\n    &lt;img src=&quot;imgs/440x200.jpg&quot; alt=&quot;&quot;&gt;\r\n&lt;/div&gt;\r\n&lt;div class=&quot;img-wrap&quot;&gt;\r\n    &lt;img src=&quot;imgs/300x200.jpg&quot; alt=&quot;&quot;&gt;\r\n&lt;/div&gt;\r\n</code></pre>\r\n<p>结构再度回归到只有一层嵌套，然而css样式却需要调整一下：</p>\r\n<pre><code class=&quot;lang-css&quot;>.img-wrap {display: inline-block;}\r\n</code></pre>\r\n<p>当我，再次进行测试的时候，心情舒畅多了，你们感受下：<a href=&quot;http://sandbox.runjs.cn/show/rf4xmo6m&quot;>图片宽度自适应（4）</a>。</p>\r\n<p>最后，补上完整的css代码：</p>\r\n<pre><code class=&quot;lang-css&quot;>.img-wrap {\r\n    display: inline-block;\r\n}\r\n.img-wrap img {\r\n    width: 100%;\r\n    vertical-align: middle;\r\n}\r\n</code></pre>\r\n<p>作者博客：<a href=&quot;http://www.seejs.com&quot;>百码山庄</a></p>\r\n', 'seejs', 'Web前端', '', '0', '1', '0', '1', '2015-11-02 09:38:53');
INSERT INTO `article` VALUES ('17', '来自腾讯张小龙的分享（全版）', '简单就是美——从苹果单按钮到微信摇一摇&lt;br&gt;今天很感谢大家从这么远的地方跑到广州来，对于产品的分享，我个人是挺有兴趣的，我觉得能够探讨一下怎么做产品，本身也是挺有意思的一件事情。\r\n\r\n这里先用一个小故事开始讲，这个故事是关于苹果手机的，为什么苹果的手机只有一个按钮？ (台下：我觉得对于用户来说，只有一个按钮不会有太多的干扰，只要从这里开始，其它的菜单都在这里面了，这是我个人的一些想法。)\r\n\r\n嘉宾：上次在分享的时候Martin也在，Martin理解的原因是因为这一个按钮很容易坏掉，所以用户要不停的去换新的手机。这个也有一定的道理，因为我上一个苹果手机的按钮就坏掉了，后来没有办法，只好又换了一个，而且换的还是微信的4S，这个还是破例寄过来的，因为他说我们的微信在4S下录视频只能录一秒，我说那还不到4S。\r\n\r\n台下：乔布斯是想说我的产品是我来引导用户使用，所以只有一个按钮的时候，你必须照我的操作，你只能按这个按钮来一步步操作。\r\n\r\n嘉宾：那两个按钮为什么就不能引导了？\r\n\r\n台下：多一个就多一个选择了。\r\n\r\n嘉宾：就不给他选择？\r\n\r\n台下：对，因为你要照我的思路来操作。之前看了《乔布斯传》，也看过一些，我感觉乔布斯是性格上有一点偏执的，他追求一种极致的简洁，可能跟他的理念有关系。他如果能用一个按钮来实现的话，他绝对不会用两个按钮来实现。\r\n\r\n嘉宾：那能不能不用按钮？\r\n\r\n台下：其实大部分手机都不用按钮，但是可能这个按钮还是必要的。\r\n\r\n嘉宾：最重要的不是回答的正不正确，主要是看有没有一个自己的想法，任何理由都可以的。\r\n\r\n台下：简单。\r\n\r\n嘉宾：对，简单是一个很好的回答，非常好。这个问题其实没有一个标准答案。\r\n\r\n台下：我想补充一下，如果死机的话可能会把手机摔了，这可能是一个发泄的入口。\r\n\r\n嘉宾：发泄用的？\r\n\r\n台下：如果死机的话你会把它摔了，所以用户要去点。\r\n\r\n嘉宾：对，这也是很合理的，因为发泄很重要的。这个没有标准答案，我说的答案也是一个仅供参考的答案，大家不要当真。为什么只有一个按钮？你再看一下为什么是白色的？其实白色的比黑的更酷一些，对不对？白色的其实是苹果最想做的，当时是做不出来，供应商做不到，所以就做了黑的先来应付一下大家，所以做了很久，后来才做出了白色的。你看这个白色的机子，再加上一个按钮，你会想到什么？一个白色的东西加一个按钮在上面，并且一按就会有奇迹发生，并且一按就会有一些事情发生了。\r\n\r\n台下：像马桶。\r\n\r\n嘉宾：对了。我看过一个故事，苹果的首席设计师叫乔纳森·艾弗，他以前是做马桶设计的。一个设计师设计的经验会延续的，所以你可以想象得到这里面包含了一些历史的经验。我们经常看到一些马桶上面有两个按钮，那个体验就不好了，你每次冲水都不知道该按大的按钮还是按小的按钮。\r\n\r\n台下：我每次冲水的时候都两个按钮一起按。\r\n\r\n嘉宾：那你是浪费水。这是我开的一个小玩笑，不是一个真实的东西。但是这个玩笑里面其实也是有一些故事，这个故事就是艾弗设计师以前确实是做日用品的设计，当时他的很多积累是来自于工业用品。然后到苹果以后，后来乔布斯回到苹果以后，发现他的设计理念跟乔布斯的很接近，然后才留下来一起来做。\r\n\r\n我们现在用的很多是苹果的东西，这里面的很多产品是可以给我们很多启发的。所以对于苹果为什么这么做，它的硬件为什么这样做？软件为什么这样做？其实有很多值得思考的地方。我自己也看了《乔布斯传》这本书，我看了以后觉得它没有把苹果的一些设计思想和精髓写出来，比如说的一些故事。在IPhone发布的时候，他说我们这个产品是领先其它手机5年的，这个5年领先在什么地方？IOS的设计，它的理念是什么？它的哲学是什么？这个其实是很值得去思考的。\r\n\r\n这个故事就讲到这里，我们开始今天的正题，先用简单的思维来开始。这句话大家都听了很多，听得已经起老茧了，包括少就是多，为什么少就是多？为什么简单就是美？在这里我也希望大家能参与一下，看哪位同学先来回答一下这个问题？为什么简单就是美？为什么复杂就不美了？有没有哪位同学有勇气按照自己的理解来回答一下？\r\n\r\n什么才是简单——从腾讯微信说起\r\n\r\n我相信男生都用了，女生用了也不会告诉我们。大家都用了吧？我摇到了一个TINA的三公里以外的。如果大家想加我的话可以一起摇一下，我们可以互加一下。但是深圳的同事，你们在100公里以外就加不到了。我们必须要同时摇，我们数1、2、3，当数到3就同时摇。大家都进入这个界面了吗？1、2、3，摇！因为必须在三秒之内摇，然后我们会看到一个列表，刚好我们摇的人就在这个里面了。我们看到这个列表里面有十几个人，就是我们刚才一起摇的人。基本上是都能捕捉到的。\r\n\r\n大家可能已经在讨论这里面的技术问题了，这个是怎么样互相找的。这个技术问题，我相信不是一个问题，对于腾讯的技术来说，这个非常容易就做到了。我这里想说的是，作为一个产品功能，我们为什么要这样做？这个功能非常简单，优秀的开发同事可能一两天就可以开发出来，但是我们怎么样把一个功能做成一种极简的体验，这个难度非常难。\r\n\r\n你可能今天看到摇一摇的功能很简单，如果我们做也很容易，问题就在这里，如果我们面对一个功能的时候，我们能做到这个地步，并且是别人还没有这样做过的时候，我们这样做了，这是非常难的。这里是有一些方法可以遵循的，也就是简单是美的方法。我们看一下这里面体现出来什么样简单的特点。\r\n\r\n在这个界面里面没有任何的按钮，没有任何的菜单，也没有任何的其它入口。下面多了一个菜单可以拉出来，上一次摇到的人，这个是我们的一个败笔，准备把它给取消掉的。也就是这个界面没有任何的东西，只有一个图案，没有按钮，没有菜单，没有文字介绍。那么这个就像是Iphone的手机或者马桶只有一个按钮是一样的道理，它只有一个图片，然后这个图片只需要用户做一个动作，就是摇一摇的动作。这个动作也非常简单，这是人类有史以来最有启发性的一个动作。我因此而研究过人类的起源，人类为什么会直立行走？因为人类要把手用来抓石头，用来打猎，最后脚就用来做别的东西了，最后就直立行走了。\r\n\r\n然后我们内部开发这个功能的时候，我们把它叫做“（录一录）”功能，内部代码叫“录一录”，我们的服务器上开发的代码叫（Lusefor）。这是人类最原始的东西，最原始的东西往往就是体验最好的。前不久我在微博上写过一句话，我们怎么样体现出最原始的东西就是体验最好的。我们回忆一下在Windows的时代，多任务是怎么体现出来的，我们要按“ALT+Tab”键，然后在Iphone里面，我们只要按底下这个按钮按两次就可以了，这个简单很多。在苹果底下，四个指头把它录下来就可以了，它就可以把多任务给切换过来了。我们看到这是一个从复杂到简单的演化过程，实际上ALT+Tab是非常复杂，很不人性化的。所以我们说Windows的体验不好，MICoS的体验好，经常会有人争论，争论到最后，大家要有一个判断依据，依据是什么，哪个东西更人性化或者更简单，或者更原始，它就是好的。我们买一个iPhone或者iPad给一个四岁小孩子用都会用，四岁的小孩体现的是它的原始或者简单，那么它是体验好的，如果要经过学习，它就不好了。\r\n\r\n同样的，我们来看这个“摇一摇”的功能，它非常简单，任何一个人都会用，不用做任何的学习。我们会避免在界面里面出现任何的一个文字解释，一旦一个功能需要文字解释，这个功能的设计已经失败了。\r\n\r\n我们很喜欢在程序里面加一些TIP，觉得这是一个很好的教育手段。如果你需要有一个TIP去教育用户，证明也很失败，你没有办法通过功能本身让用户一看就知道。那么用户看了这个以后，他会下意识的就摇一下，摇一下以后，这时候要给他一些刺激回馈出来，那么他会听到一个来福枪的声音，我们故意找一个来福枪的声音，这个声音很刺激。我们原来以为只有男生喜欢，后来发现女生也很喜欢，因为它代表了雄性。本来我们给女生设计的是一个“丁丁当当”的声音，后来把它取消了，都做成这个声音了。然后最初的版本摇一摇，后面是一个裸体女人的上半身，那是维纳斯，是艺术。但是我们的很多用户，包括公司内部的同事甚至领导说这个影响会不太好吧？然后我们就把它改成了一朵小花。所以到我们要放弃艺术，要追求一种大众的好的时候，其实损失就更多了。\r\n\r\n你会看到这个过程很有意思，先有一个声音，然后有一扇门打开，再合上。然后甚至在打开的时候，如果你想换一个图片的话，你可以把手指伸到这个缝里面去点一下，点一下可以换一个背景图，没有发现吧？\r\n\r\n台下：发现了。\r\n\r\n嘉宾：还是女生发现了，不是男生发现了。上一次Pony很认真的给我发了一个邮件，说我们摇一摇的功能真的很好，但是我们要防止竞争对手抄袭模仿我们的功能。因为上次我们做了一个查看附近的人，然后竞争对手也做了，并且加了一个小创新在里面，叫做表白功能。这样通过一个小创新来突出，跟我们就不一样了。Pony说为什么我们没有预先把这些该想到的都想进去，让别人想模仿的时候都没有办法再来做一个微创新了。我说微创新是永无止境的，别人总可以加一点东西来跟你不太一样。然后他说这个摇一摇，我们怎么样能够把该做的都做了，而且别人没法在上面来改变一下。我说不用着急了，因为我们这个东西已经做到最简化了，别人没法超越了，我们当时是有这种自信的。这种自信一方面是说我们已经最简化了，因为就像这个手机只有一个按钮一样，除非你做一个没有按钮的手机。这里只有一个动作，甚至连按钮都没有。另外一个原因，我当时在邮件里面解释了，我说这个体验的整个过程是非常严实的，它是一种人类的性的驱动力在完成整个过程的，没有什么吸引你的驱动力比性的驱动力会更加原始，这是弗洛依德说的，不是我说的。所以这也是一个科学，不是一个道德低下的问题。\r\n\r\n从这两个角度，一方面是它确实做得很简单，另外一方面它让你很爽，这个爽是来自很深层次的原因。所以我们说我们的竞争对手无法超越，就是这个原因。我不知道你们有没有赞同这一点或者理解到这一点。看起来很简单的一个东西，但是它已经是要有一些方法或者一些思考去达成这种简单的。手机里面可以体现出这种东西出来，因为手机可以认为是手指的一个衍生，是你的第六根指头。所以在手机底下体验是有一个非常有突破的空间，这跟你在电脑上通过鼠标和键盘来交付是不一样的，手机是跟你的身体连在一起的，是很直接的。为什么很多人喜欢汽车，对汽车那么追求？汽车是你的双腿的延伸。那个才是真正的体验。相反的，我们通过鼠标、通过键盘，就像你摸一个女孩子还要隔着衣服一样的。手机是很直接的。\r\n\r\n怎么样看待简单是美？我的理解是简单是一种审美观，它不是一种完全非常理性的结论说我们尽可能的做得简陋一点就好了。而是说你脑袋里面是不是有一种观念在这里，但是你看到一个界面，一看它密密麻麻的铺满了按钮，然后你就知道这个东西一点都不美，然后你就说这里不对，你要把它给简化一下。这种审美就很难解释了，我就不多讲了，再往下看。', '<p>简单就是美——从苹果单按钮到微信摇一摇<br>今天很感谢大家从这么远的地方跑到广州来，对于产品的分享，我个人是挺有兴趣的，我觉得能够探讨一下怎么做产品，本身也是挺有意思的一件事情。\r\n<p>这里先用一个小故事开始讲，这个故事是关于苹果手机的，为什么苹果的手机只有一个按钮？ (台下：我觉得对于用户来说，只有一个按钮不会有太多的干扰，只要从这里开始，其它的菜单都在这里面了，这是我个人的一些想法。)</p>\r\n<p>嘉宾：上次在分享的时候Martin也在，Martin理解的原因是因为这一个按钮很容易坏掉，所以用户要不停的去换新的手机。这个也有一定的道理，因为我上一个苹果手机的按钮就坏掉了，后来没有办法，只好又换了一个，而且换的还是微信的4S，这个还是破例寄过来的，因为他说我们的微信在4S下录视频只能录一秒，我说那还不到4S。</p>\r\n<p>台下：乔布斯是想说我的产品是我来引导用户使用，所以只有一个按钮的时候，你必须照我的操作，你只能按这个按钮来一步步操作。</p>\r\n<p>嘉宾：那两个按钮为什么就不能引导了？</p>\r\n<p>台下：多一个就多一个选择了。</p>\r\n<p>嘉宾：就不给他选择？</p>\r\n<p>台下：对，因为你要照我的思路来操作。之前看了《乔布斯传》，也看过一些，我感觉乔布斯是性格上有一点偏执的，他追求一种极致的简洁，可能跟他的理念有关系。他如果能用一个按钮来实现的话，他绝对不会用两个按钮来实现。</p>\r\n<p>嘉宾：那能不能不用按钮？</p>\r\n<p>台下：其实大部分手机都不用按钮，但是可能这个按钮还是必要的。</p>\r\n<p>嘉宾：最重要的不是回答的正不正确，主要是看有没有一个自己的想法，任何理由都可以的。</p>\r\n<p>台下：简单。</p>\r\n<p>嘉宾：对，简单是一个很好的回答，非常好。这个问题其实没有一个标准答案。</p>\r\n<p>台下：我想补充一下，如果死机的话可能会把手机摔了，这可能是一个发泄的入口。</p>\r\n<p>嘉宾：发泄用的？</p>\r\n<p>台下：如果死机的话你会把它摔了，所以用户要去点。</p>\r\n<p>嘉宾：对，这也是很合理的，因为发泄很重要的。这个没有标准答案，我说的答案也是一个仅供参考的答案，大家不要当真。为什么只有一个按钮？你再看一下为什么是白色的？其实白色的比黑的更酷一些，对不对？白色的其实是苹果最想做的，当时是做不出来，供应商做不到，所以就做了黑的先来应付一下大家，所以做了很久，后来才做出了白色的。你看这个白色的机子，再加上一个按钮，你会想到什么？一个白色的东西加一个按钮在上面，并且一按就会有奇迹发生，并且一按就会有一些事情发生了。</p>\r\n<p>台下：像马桶。</p>\r\n<p>嘉宾：对了。我看过一个故事，苹果的首席设计师叫乔纳森·艾弗，他以前是做马桶设计的。一个设计师设计的经验会延续的，所以你可以想象得到这里面包含了一些历史的经验。我们经常看到一些马桶上面有两个按钮，那个体验就不好了，你每次冲水都不知道该按大的按钮还是按小的按钮。</p>\r\n<p>台下：我每次冲水的时候都两个按钮一起按。</p>\r\n<p>嘉宾：那你是浪费水。这是我开的一个小玩笑，不是一个真实的东西。但是这个玩笑里面其实也是有一些故事，这个故事就是艾弗设计师以前确实是做日用品的设计，当时他的很多积累是来自于工业用品。然后到苹果以后，后来乔布斯回到苹果以后，发现他的设计理念跟乔布斯的很接近，然后才留下来一起来做。</p>\r\n<p>我们现在用的很多是苹果的东西，这里面的很多产品是可以给我们很多启发的。所以对于苹果为什么这么做，它的硬件为什么这样做？软件为什么这样做？其实有很多值得思考的地方。我自己也看了《乔布斯传》这本书，我看了以后觉得它没有把苹果的一些设计思想和精髓写出来，比如说的一些故事。在IPhone发布的时候，他说我们这个产品是领先其它手机5年的，这个5年领先在什么地方？IOS的设计，它的理念是什么？它的哲学是什么？这个其实是很值得去思考的。</p>\r\n<p>这个故事就讲到这里，我们开始今天的正题，先用简单的思维来开始。这句话大家都听了很多，听得已经起老茧了，包括少就是多，为什么少就是多？为什么简单就是美？在这里我也希望大家能参与一下，看哪位同学先来回答一下这个问题？为什么简单就是美？为什么复杂就不美了？有没有哪位同学有勇气按照自己的理解来回答一下？</p>\r\n<p>什么才是简单——从腾讯微信说起</p>\r\n<p>我相信男生都用了，女生用了也不会告诉我们。大家都用了吧？我摇到了一个TINA的三公里以外的。如果大家想加我的话可以一起摇一下，我们可以互加一下。但是深圳的同事，你们在100公里以外就加不到了。我们必须要同时摇，我们数1、2、3，当数到3就同时摇。大家都进入这个界面了吗？1、2、3，摇！因为必须在三秒之内摇，然后我们会看到一个列表，刚好我们摇的人就在这个里面了。我们看到这个列表里面有十几个人，就是我们刚才一起摇的人。基本上是都能捕捉到的。</p>\r\n<p>大家可能已经在讨论这里面的技术问题了，这个是怎么样互相找的。这个技术问题，我相信不是一个问题，对于腾讯的技术来说，这个非常容易就做到了。我这里想说的是，作为一个产品功能，我们为什么要这样做？这个功能非常简单，优秀的开发同事可能一两天就可以开发出来，但是我们怎么样把一个功能做成一种极简的体验，这个难度非常难。</p>\r\n<p>你可能今天看到摇一摇的功能很简单，如果我们做也很容易，问题就在这里，如果我们面对一个功能的时候，我们能做到这个地步，并且是别人还没有这样做过的时候，我们这样做了，这是非常难的。这里是有一些方法可以遵循的，也就是简单是美的方法。我们看一下这里面体现出来什么样简单的特点。</p>\r\n<p>在这个界面里面没有任何的按钮，没有任何的菜单，也没有任何的其它入口。下面多了一个菜单可以拉出来，上一次摇到的人，这个是我们的一个败笔，准备把它给取消掉的。也就是这个界面没有任何的东西，只有一个图案，没有按钮，没有菜单，没有文字介绍。那么这个就像是Iphone的手机或者马桶只有一个按钮是一样的道理，它只有一个图片，然后这个图片只需要用户做一个动作，就是摇一摇的动作。这个动作也非常简单，这是人类有史以来最有启发性的一个动作。我因此而研究过人类的起源，人类为什么会直立行走？因为人类要把手用来抓石头，用来打猎，最后脚就用来做别的东西了，最后就直立行走了。</p>\r\n<p>然后我们内部开发这个功能的时候，我们把它叫做“（录一录）”功能，内部代码叫“录一录”，我们的服务器上开发的代码叫（Lusefor）。这是人类最原始的东西，最原始的东西往往就是体验最好的。前不久我在微博上写过一句话，我们怎么样体现出最原始的东西就是体验最好的。我们回忆一下在Windows的时代，多任务是怎么体现出来的，我们要按“ALT+Tab”键，然后在Iphone里面，我们只要按底下这个按钮按两次就可以了，这个简单很多。在苹果底下，四个指头把它录下来就可以了，它就可以把多任务给切换过来了。我们看到这是一个从复杂到简单的演化过程，实际上ALT+Tab是非常复杂，很不人性化的。所以我们说Windows的体验不好，MICoS的体验好，经常会有人争论，争论到最后，大家要有一个判断依据，依据是什么，哪个东西更人性化或者更简单，或者更原始，它就是好的。我们买一个iPhone或者iPad给一个四岁小孩子用都会用，四岁的小孩体现的是它的原始或者简单，那么它是体验好的，如果要经过学习，它就不好了。</p>\r\n<p>同样的，我们来看这个“摇一摇”的功能，它非常简单，任何一个人都会用，不用做任何的学习。我们会避免在界面里面出现任何的一个文字解释，一旦一个功能需要文字解释，这个功能的设计已经失败了。</p>\r\n<p>我们很喜欢在程序里面加一些TIP，觉得这是一个很好的教育手段。如果你需要有一个TIP去教育用户，证明也很失败，你没有办法通过功能本身让用户一看就知道。那么用户看了这个以后，他会下意识的就摇一下，摇一下以后，这时候要给他一些刺激回馈出来，那么他会听到一个来福枪的声音，我们故意找一个来福枪的声音，这个声音很刺激。我们原来以为只有男生喜欢，后来发现女生也很喜欢，因为它代表了雄性。本来我们给女生设计的是一个“丁丁当当”的声音，后来把它取消了，都做成这个声音了。然后最初的版本摇一摇，后面是一个裸体女人的上半身，那是维纳斯，是艺术。但是我们的很多用户，包括公司内部的同事甚至领导说这个影响会不太好吧？然后我们就把它改成了一朵小花。所以到我们要放弃艺术，要追求一种大众的好的时候，其实损失就更多了。</p>\r\n<p>你会看到这个过程很有意思，先有一个声音，然后有一扇门打开，再合上。然后甚至在打开的时候，如果你想换一个图片的话，你可以把手指伸到这个缝里面去点一下，点一下可以换一个背景图，没有发现吧？</p>\r\n<p>台下：发现了。</p>\r\n<p>嘉宾：还是女生发现了，不是男生发现了。上一次Pony很认真的给我发了一个邮件，说我们摇一摇的功能真的很好，但是我们要防止竞争对手抄袭模仿我们的功能。因为上次我们做了一个查看附近的人，然后竞争对手也做了，并且加了一个小创新在里面，叫做表白功能。这样通过一个小创新来突出，跟我们就不一样了。Pony说为什么我们没有预先把这些该想到的都想进去，让别人想模仿的时候都没有办法再来做一个微创新了。我说微创新是永无止境的，别人总可以加一点东西来跟你不太一样。然后他说这个摇一摇，我们怎么样能够把该做的都做了，而且别人没法在上面来改变一下。我说不用着急了，因为我们这个东西已经做到最简化了，别人没法超越了，我们当时是有这种自信的。这种自信一方面是说我们已经最简化了，因为就像这个手机只有一个按钮一样，除非你做一个没有按钮的手机。这里只有一个动作，甚至连按钮都没有。另外一个原因，我当时在邮件里面解释了，我说这个体验的整个过程是非常严实的，它是一种人类的性的驱动力在完成整个过程的，没有什么吸引你的驱动力比性的驱动力会更加原始，这是弗洛依德说的，不是我说的。所以这也是一个科学，不是一个道德低下的问题。</p>\r\n<p>从这两个角度，一方面是它确实做得很简单，另外一方面它让你很爽，这个爽是来自很深层次的原因。所以我们说我们的竞争对手无法超越，就是这个原因。我不知道你们有没有赞同这一点或者理解到这一点。看起来很简单的一个东西，但是它已经是要有一些方法或者一些思考去达成这种简单的。手机里面可以体现出这种东西出来，因为手机可以认为是手指的一个衍生，是你的第六根指头。所以在手机底下体验是有一个非常有突破的空间，这跟你在电脑上通过鼠标和键盘来交付是不一样的，手机是跟你的身体连在一起的，是很直接的。为什么很多人喜欢汽车，对汽车那么追求？汽车是你的双腿的延伸。那个才是真正的体验。相反的，我们通过鼠标、通过键盘，就像你摸一个女孩子还要隔着衣服一样的。手机是很直接的。</p>\r\n<p>怎么样看待简单是美？我的理解是简单是一种审美观，它不是一种完全非常理性的结论说我们尽可能的做得简陋一点就好了。而是说你脑袋里面是不是有一种观念在这里，但是你看到一个界面，一看它密密麻麻的铺满了按钮，然后你就知道这个东西一点都不美，然后你就说这里不对，你要把它给简化一下。这种审美就很难解释了，我就不多讲了，再往下看。</p>\r\n', 'seejs', '生活百科', 'http://127.0.0.1:808/seejs/content/upload/201412111132247751-1446432983.jpg', '1', '1', '0', '1', '2015-11-02 10:57:58');

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES ('7', 'Web前端');
INSERT INTO `category` VALUES ('8', '生活百科');

-- ----------------------------
-- Table structure for comments
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `articleid` int(10) NOT NULL,
  `user` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `content` text,
  `parentid` int(10) DEFAULT NULL,
  `reply_path` varchar(255) DEFAULT NULL,
  `reply_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(2) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of comments
-- ----------------------------
INSERT INTO `comments` VALUES ('1', '15', 'mailzwj', 'mailzwj@126.com', '我的第一条评论！', null, null, '2015-11-08 11:22:25', '0');
INSERT INTO `comments` VALUES ('3', '15', '127.0.0.1', '', '1\r\n2\r\n3', null, null, '2015-11-08 11:40:18', '0');
INSERT INTO `comments` VALUES ('4', '17', '127.0.0.1', '', '大牛啊，写得真好！', null, null, '2015-11-08 11:30:24', '0');
INSERT INTO `comments` VALUES ('5', '16', '127.0.0.1', '', '加一条评论试试！！', null, null, '2015-11-08 11:40:17', '0');

-- ----------------------------
-- Table structure for link
-- ----------------------------
DROP TABLE IF EXISTS `link`;
CREATE TABLE `link` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `linkname` varchar(255) NOT NULL,
  `linkaddr` varchar(255) DEFAULT NULL,
  `linkicon` varchar(255) NOT NULL DEFAULT 'icon-link15',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of link
-- ----------------------------
INSERT INTO `link` VALUES ('6', 'Github', 'http://github.com', 'icon-github11');
INSERT INTO `link` VALUES ('7', '新浪微博', 'http://weibo.com/ys800', 'icon-weibo');
INSERT INTO `link` VALUES ('8', '微信:mailzwj', '', 'icon-speech59');

-- ----------------------------
-- Table structure for managers
-- ----------------------------
DROP TABLE IF EXISTS `managers`;
CREATE TABLE `managers` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `adminname` varchar(16) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of managers
-- ----------------------------
INSERT INTO `managers` VALUES ('1', 'seejs', 'a98932365dbfc586515ce9dc92ea41c8', '1');

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `menu` varchar(255) NOT NULL,
  `menulink` varchar(255) DEFAULT NULL,
  `parent` int(10) DEFAULT '0',
  `sort` int(10) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('4', '首页', './index.php', '0', '1');
INSERT INTO `menu` VALUES ('5', '关于', './about.php', '0', '1');

-- ----------------------------
-- Table structure for praise
-- ----------------------------
DROP TABLE IF EXISTS `praise`;
CREATE TABLE `praise` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `articleid` int(10) NOT NULL,
  `ip` varchar(255) DEFAULT '*.*.*.*',
  `status` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of praise
-- ----------------------------
INSERT INTO `praise` VALUES ('1', '15', '127.0.0.1', '1');
INSERT INTO `praise` VALUES ('2', '17', '10.28.164.181', '1');

-- ----------------------------
-- Table structure for siteinfo
-- ----------------------------
DROP TABLE IF EXISTS `siteinfo`;
CREATE TABLE `siteinfo` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `logo` varchar(255) NOT NULL,
  `sitename` varchar(255) NOT NULL,
  `subname` varchar(255) DEFAULT NULL,
  `used` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of siteinfo
-- ----------------------------
INSERT INTO `siteinfo` VALUES ('2', 'http://127.0.0.1:808/seejs/content/upload/logo-1446427876.png', 'SEEJS', '用生命去开发~~', '1');

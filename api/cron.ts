import type { VercelRequest, VercelResponse } from '@vercel/node';
 
export default async function handler(
	request: VercelRequest,
	response: VercelResponse,
  ) {
	try {
	  const result = await fetch(
		'https://laravel-chatgpt-blog.vercel.app/api/api/create-post',
	  );
	  const data = await result.json();
   
	  if (data.success) {
		response
		  .status(200)
		  .json({ message: `Successfully queued job.` });
	  } else {
		response.status(500).json({ error: 'Failed to queue job' });
	  }
	} catch (error) {
	  response.status(500).json({ error: 'Failed to queue job' });
	}
  }